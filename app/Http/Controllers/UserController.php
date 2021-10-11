<?php

namespace App\Http\Controllers;

//use App\User;
//use App\Http\Requests\UserRequest;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */

    /*public function index(User $model)
    {
        return view('users.index');
    }*/
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(10);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();

        $randomcolor = '#' . dechex(rand(0,10000000));

        return view('users.create',compact('roles', 'randomcolor'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'color' => 'required|unique:users',
            'roles' => 'required'
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);


        $user = User::create($input);
        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $randomcolor = '#' . dechex(rand(0,10000000));
        if(Auth::user()->can('role-edit') or $user->id == Auth::user()->id)
        {
          $roles = Role::pluck('name','name')->all();
          $userRole = $user->roles->pluck('name','name')->all();

          return view('users.edit',compact('user','roles','userRole', 'randomcolor'));
        } else {
          return redirect()->route('users.index');
        }

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'color' => 'required|unique:users',
            'roles' => 'required'
        ]);


        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }


}
