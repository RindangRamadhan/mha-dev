<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return User::all();
    }

    public function index(Request $request)
    {
        $users = User::with('role')->where(function($query) use ($request){
					$query->orwhere('name', 'LIKE', '%' . $request->search . '%')
					->orwhere('email', 'LIKE', '%' . $request->search . '%');
                })->orderBy('id','desc')->paginate(10);
        $data = [];

        foreach($users as $user){
            $role = Role::find($user->role->role_id);
            $data[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'otoritas' => $role->display_name,
                ];
        }

        return app(PaginateController::class)->getPagination($users, $data, '/api/users');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'otoritas' => 'required'
        ]);  

        $user = User::create([
              'name' => $request->name,
              'email' => $request->email,
              'password' => bcrypt($request->password),
              'api_token' => str_random(100)
           ]);

        $role = Role::where('id',$request->otoritas)->first();
        $user->attachRole($role);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::select('id','name','email')->with('role')->whereId($id)->first();
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'otoritas' => 'required'
        ]);  

        $user = User::with('role')->whereId($id);

        $role_lama = Role::where('id',$user->first()->role->role_id)->first();

        $user->update([
              'name' => $request->name,
              'email' => $request->email,
           ]);

        $role = Role::where('id',$request->otoritas)->first();
        $user = User::find($id);
        $user->detachRole($role_lama->id);
        $user->attachRole($role);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->detachRole($user->role->role_id);
        $user->destroy($id);
        return response(200);
    }
}
