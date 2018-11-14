<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Server;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $servers = Server::where(function($query) use ($request){
            $query->orwhere('name', 'LIKE', '%' . $request->search . '%');
        })->orderBy('id','desc')->paginate(10);
        $data = [];

        foreach($servers as $server){
            $data[] = [
                'id' => $server->id,
                'name' => $server->name,
            ];
        }

        return app(PaginateController::class)->getPagination($servers, $data, '/api/server');
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
            'name' => 'required|string|max:255|unique:servers',
        ]);  

        $server = Server::create([
            'name' => $request->name,
        ]);

        return $server;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Server::find($id);
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
            'name' => 'required|string|max:255|unique:servers,name,'.$id,
        ]);
        
        $server = Server::find($id);
        $server->update([
            'name' => $request->name,
        ]);

        return $server;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $server = Server::find($id);
        $server->destroy($id);
        return response(200);
    }
}
