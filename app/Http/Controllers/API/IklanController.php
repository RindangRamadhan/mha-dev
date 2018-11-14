<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Iklan;

class IklanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $iklans = Iklan::where(function($query) use ($request){
            $query->orwhere('name', 'LIKE', '%' . $request->search . '%');
        })->orderBy('id','desc')->paginate(10);
        $data = [];

        foreach($iklans as $iklan){
            $data[] = [
                'id' => $iklan->id,
                'name' => $iklan->name,
            ];
        }

        return app(PaginateController::class)->getPagination($iklans, $data, '/api/iklan');
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
            'name' => 'required|string|max:255|unique:iklans',
        ]);  

        $iklan = Iklan::create([
            'name' => $request->name,
        ]);

        return $iklan;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Iklan::find($id);
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
            'name' => 'required|string|max:255|unique:iklans,name,'.$id,
        ]);
        
        $iklan = Iklan::find($id);
        $iklan->update([
            'name' => $request->name,
        ]);

        return $iklan;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $iklan = Iklan::find($id);
        $iklan->destroy($id);
        return response(200);
    }
}
