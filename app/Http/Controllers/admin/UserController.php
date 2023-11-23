<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Barangay;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $users = User::where('name', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%')
            ->with('roles')
            ->paginate(10);

        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles', 'query'));
    }

    public function create()
    {
        $roles = Role::all();
        $barangays = Barangay::all();

        return view('admin.users.create', compact('roles', 'barangays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => $request->filled('is_active') && $request->input('is_active') == 'on',
            'barangay_id' => $request->barangay, // Add this line
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
        ]);

        // Check if the authenticated user is an admin
        if (auth()->user()->hasRole('admin')) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'is_active' => $request->has('is_active') && $request->input('is_active') == '1',
                'barangay_id' => $request->barangay, // Add this line
            ]);
        } else {
            // For non-admin users, update other fields but not is_active
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
