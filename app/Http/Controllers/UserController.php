<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::when($search, function ($query) use ($search) {

            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");

        })->oldest()->paginate(4);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        if($request->role_id){
            $user->attachRole($request->role_id);
        }

        return redirect()->route('users.index')
            ->with('success','User Created Successfully');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.edit', compact(
            'user',
            'roles'
        ));
    }

    public function update(Request $request, User $user)
    {
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email
        ]);

        return redirect()->route('users.index')
            ->with('success','User Updated Successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()
            ->with('success','User Deleted Successfully');
    }
}