<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller



{
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = 'admin'; // Assign 'admin' role
        $user->save();

        return redirect()->route('admin.create')->with('success', 'Admin created successfully.');
    }

    public function changePassword()
{
    return view('admin.change_password');
}

public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect']);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->route('admin.change_password')->with('success', 'Password changed successfully.');
}


public function edit($id)
{
    $admin = User::findOrFail($id);
    return view('admin.edit', compact('admin'));
}

public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
                         ->withErrors($validator)
                         ->withInput();
    }

    try {
        $admin = User::findOrFail($id);
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->input('password'));
        }

        $admin->save();

        return redirect()->route('admin.index')->with('success', 'Admin updated successfully.');
    } catch (\Exception $e) {
        return redirect()->route('admin.index')->with('error', 'Failed to update admin.');
    }
}

public function remove($id)
{
    $admin = User::findOrFail($id);
    $admin->delete();

    return redirect()->route('admin.index')->with('success', 'Admin removed successfully.');
}

}
