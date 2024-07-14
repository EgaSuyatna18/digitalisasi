<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index() {
        $title = config('app.name') . ' | User';
        $users = User::where('role', 'admin')->get();
        return view('dashboard.user', compact('title', 'users'));
    }

    function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:50',
            'username' => 'required|string|min:6|max:12|unique:users',
            'password' => 'required|string|min:6|max:20'
        ]);

        $validated['role'] = 'admin';
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect(route('user_index'))->with('success', 'Berhasil Menambah user.');
    }

    function destroy(User $user) {
        $user->delete();
        return redirect(route('user_index'))->with('success', 'Berhasil menghapus user.');
    }

    function update(User $user, Request $request) {
        $rules = [
            'name' => 'required|string|min:2|max:50',
            'username' => 'required|string|min:6|max:12|unique:users',
        ];

        if($request->password) $rules['password'] = 'required|string|min:6|max:20';

        $validated = $request->validate($rules);

        if($request->password) $validated['password'] = Hash::make($validated['password']);

        $user->update($validated);

        return redirect(route('user_index'))->with('success', 'Berhasil mengubah user.');
    }
}
