<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return inertia('User/All', ['users' => $users]);
    }

    public function add()
    {
        return inertia('User/Add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|min:6',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);
        return to_route('user.index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return inertia('User/Edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->image != null) {
            Storage::disk('public')->delete($user->image);
            $validated['image'] = $request->file('image')->store('images', 'public');
        } else {
            $validated['image'] = $user->image;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return to_route('user.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        Storage::disk('public')->delete($user->image);
        $user->delete();
        return to_route('user.index');
    }
}
