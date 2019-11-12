<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact(['user', 'roles']));
    }

    public function update(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'role_id' => 'required|numeric',
        ]);

        $user->name = $request->name;
        $user->role_id = $request->role_id;

        $user->save();

        return redirect('/');
    }

    public function updatePassword(User $user, Request $request)
    {
        $request->validate([
            'pass1' => 'required|min:6',
            'pass2' => 'required|same:pass1',
        ]);
        $user->password = bcrypt($request->pass1);
        $user->save();
        return back()->with("success", "Пароль изменен");

    }
}
