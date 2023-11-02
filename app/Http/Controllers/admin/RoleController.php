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
        $roles = Role::where('name', 'like', '%' . $query . '%')->paginate(10);
        return view('admin.roles.index', compact('roles', 'query'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create_modal', compact('permissions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
            'permissions' => 'array', // Assuming the permissions are sent as an array
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
            return redirect()->route('roles.index')->with('error', 'Failed to create the role.');
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
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        DB::beginTransaction();

        try {
            // Update the role
            $role->name = $request->name;
            $role->save();

            // Sync permissions
            $role->syncPermissions($request->permissions);

            DB::commit();

            return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')->with('error', 'Failed to update the role.');
        }
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
