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
            'view-reports', 'view-categories', 'create-categories', 'destroy-categories', 'edit-categories',
            'view-medicines', 'create-medicines', 'edit-medicines', 'destroy-medicines',
            'view-patients', 'create-patients', 'edit-patients', 'destroy-patients',
            'view-barangays', 'create-barangays', 'edit-barangays', 'destroy-barangays',
            'view-barangay_schedules', 'create-barangay_schedules', 'edit-barangay_schedules', 'destroy-barangay_schedules',
            'view-users', 'create-user', 'edit-user', 'destroy-user',
            'view-access-control',
            'view-role', 'edit-role', 'destroy-role', 'create-role',
            'view-permission', 'create-permission', 'edit-permission', 'destroy-permission',
            'view-expired-products', 'view-outstock-products', 'backup-app', 'backup-db', 'view-settings',
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
