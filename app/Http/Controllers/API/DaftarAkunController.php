<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DaftarAkun;

class DaftarAkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $daftar_akuns = DaftarAkun::select('daftar_akuns.id as id', 'daftar_akuns.id_user as id_user', 'daftar_akuns.nama_akun as nama_akun', 'users.name as nama_user')
            ->join('users', 'daftar_akuns.id_user', 'users.id')
            ->where(function($query) use ($request){
                $query->orwhere('daftar_akuns.nama_akun', 'LIKE', '%' . $request->search . '%')
                      ->orwhere('users.name', 'LIKE', '%' . $request->search . '%');
            })
        ->orderBy('daftar_akuns.id','desc')->paginate(10);
        $data = [];

        foreach($daftar_akuns as $daftar_akun){
            $data[] = [
                'id' => $daftar_akun->id,
                'nama_user' => $daftar_akun->nama_user,
                'nama_akun' => $daftar_akun->nama_akun,
            ];
        }

        return app(PaginateController::class)->getPagination($daftar_akuns, $data, '/api/daftar-akun');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'id_user' => 'required',
            'nama_akun' => 'required|string|max:255|unique:daftar_akuns',
        ]);  

        $daftar_akun = DaftarAkun::create([
            'id_user' => $request->id_user,
            'nama_akun' => $request->nama_akun,
        ]);

        return $daftar_akun;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DaftarAkun::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'id_user' => 'required',
            'nama_akun' => 'required|string|max:255|unique:daftar_akuns,nama_akun,'.$id,
        ]);
        
        $daftar_akun = DaftarAkun::find($id);
        $daftar_akun->update([
            'id_user' => $request->id_user,
            'nama_akun' => $request->nama_akun,
        ]);

        return $daftar_akun;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $daftar_akun = DaftarAkun::find($id);
        $daftar_akun->destroy($id);
        return response(200);
    }
}
