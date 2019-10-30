<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function edit(User $user){
        $roles = Role::all();
        return view('users.edit', compact(['user','roles']));
    }

    public function update(User $user, Request $request){
        $request->validate([
            'name' => 'required|min:2',
            'role_id' => 'required|numeric',
        ]);

        $user->name = $request->name;
        $user->role_id = $request->role_id;

        $user->save();

        return redirect('/');
    }
}
