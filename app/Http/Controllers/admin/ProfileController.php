<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $roles = Role::all();

        return view('admin.profile.edit', compact('user', 'roles'));
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required|exists:roles,name',
            ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $user->syncRoles([$request->role]);

            return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('profile.edit')->with('error', 'An error occurred while updating the profile: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
{
    try {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('profile.edit')->with('success', 'Password updated successfully.');
        }

        return redirect()->route('profile.edit')->with('error', 'Current password is incorrect.');
    } catch (\Exception $e) {
        return redirect()->route('profile.edit')->with('error', 'An error occurred while updating the password: ' . $e->getMessage());
    }
}
}
