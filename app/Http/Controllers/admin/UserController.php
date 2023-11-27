<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Barangay;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $entries = $request->input('entries', 10);
        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');

        $users = User::with('roles')
            ->where('name', 'like', '%' . $query . '%')
            ->when($query, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('email', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('is_active', 'like', '%' . $request->input('search') . '%');
            })
            ->orWhereHas('roles', function ($roleQuery) use ($request) {
                $roleQuery->where('name', 'like', '%' . $request->input('search') . '%');
            })
            ->orderBy($column, $order)
            ->paginate($entries);

        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles', 'query', 'entries', 'column', 'order'));
    }
    public function create()
    {
        $roles = Role::all();
        $barangays = Barangay::all();

        return view('admin.users.create', compact('roles', 'barangays'));
    }
    public function store(Request $request)
    {
        try {
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
                'barangay_id' => $request->barangay,
            ]);

            $user->assignRole($request->role);

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'An error occurred while creating the user. Please try again.');
        }
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }
    public function update(Request $request, $id)
    {
        try {
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
                    'barangay_id' => $request->barangay,
                ]);
            } else {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
            }

            $user->syncRoles([$request->role]);

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'An error occurred while updating the user. Please try again.');
        }
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
