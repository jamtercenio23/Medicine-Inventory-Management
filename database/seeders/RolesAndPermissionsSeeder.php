<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //create permissions
        $arrayOfPermissionNames = [
            'view-distributions', 'create-distributions', 'destroy-distributions', 'edit-distributions',
            'view-distribution-barangay', 'create-distribution-barangay', 'destroy-distribution-barangay', 'edit-distribution-barangay',
            'view-reports', 'view-categories', 'create-categories', 'destroy-categories', 'edit-categories',
            'view-medicines', 'create-medicines', 'edit-medicines', 'destroy-medicines',
            'view-patients', 'create-patients', 'edit-patients', 'destroy-patients',
            'view-barangays', 'create-barangays', 'edit-barangays', 'destroy-barangays',
            'view-schedules', 'create-schedules', 'edit-schedules', 'destroy-schedules',
            'view-users', 'create-users', 'edit-users', 'destroy-users',
            'view-access-control',
            'view-roles', 'edit-roles', 'destroy-roles', 'create-roles',
            'view-permissions', 'create-permissions', 'edit-permissions', 'destroy-permissions',
            'view-expired', 'view-out-of-stock', 'backup-app', 'backup-db', 'view-settings',
            'view-barangay_medicines', 'create-barangay_medicines', 'edit-barangay_medicines', 'destroy-barangay_medicines',
            'view-barangay_distributions', 'create-barangay_distributions', 'edit-barangay_distributions', 'destroy-barangay_distributions',
            'view-barangay_patients', 'create-barangay_patients', 'edit-barangay_patients', 'destroy-barangay_patients'
        ];
        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions->toArray());

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
        $role = Role::create(['name' => 'pharmacist'])
            ->givePermissionTo(['view-distributions', 'view-reports', 'create-distributions']);

        $role = Role::create(['name' => 'bhw'])
            ->givePermissionTo(['view-barangay_medicines', 'create-barangay_medicines', 'edit-barangay_medicines', 'destroy-barangay_medicines',
            'view-barangay_distributions', 'create-barangay_distributions', 'edit-barangay_distributions', 'destroy-barangay_distributions',
            'view-barangay_patients', 'create-barangay_patients', 'edit-barangay_patients', 'destroy-barangay_patients']);
    }
}
