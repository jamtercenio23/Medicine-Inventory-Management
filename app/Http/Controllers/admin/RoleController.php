<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $permissions = Permission::all();
        $query = $request->input('search');
        $entries = $request->input('entries', 10);
        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');

        $roles = Role::where('name', 'like', '%' . $query . '%')
            ->when($query, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('search') . '%');
            })
            ->orderBy($column, $order)
            ->paginate($entries);

        return view('admin.roles.index', compact('roles', 'query', 'entries', 'column', 'order'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create_modal', compact('permissions'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:roles',
                'permissions' => 'array',
            ]);

            DB::beginTransaction();

            try {
                $role = Role::create(['name' => $request->input('name')]);

                // Associate the selected permissions with the role
                if ($request->has('permissions')) {
                    $role->syncPermissions($request->input('permissions'));
                }

                DB::commit();

                return redirect()->route('roles.index')->with('success', 'Role created successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('roles.index')->with('error', 'Failed to create the role: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('error', 'An error occurred while processing the request: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        return view('admin.roles.edit_modal', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'name' => 'required|unique:roles,name,' . $role->id,
                'permissions' => 'array',
            ]);

            DB::beginTransaction();

            try {
                $role->name = $request->name;
                $role->save();

                $role->syncPermissions($request->permissions);

                DB::commit();

                return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('roles.index')->with('error', 'Failed to update the role: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('error', 'An error occurred while processing the request: ' . $e->getMessage());
        }
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
