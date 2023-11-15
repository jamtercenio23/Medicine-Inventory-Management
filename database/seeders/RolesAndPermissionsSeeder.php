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
            'view-admin_inventory',
            'view-admin_manage',
            'view-admin_distributions',
            'view-bhw_inventory',
            'view-bhw_manage',
            'view-bhw_distributions',
            'view-distributions',
            'view-distribution-barangay',
            'view-reports',
            'view-categories',
            'view-medicines',
            'view-patients',
            'view-barangays',
            'view-schedules',
            'view-users',
            'view-access-control',
            'view-roles',
            'view-permissions',
            'view-expired',
            'view-out-of-stock',
            'backup-app',
            'backup-db',
            'view-settings',
            'view-barangay_medicines',
            'view-barangay_out-of-stock',
            'view-barangay_expired',
            'view-barangay_distributions',
            'view-barangay_patients',
        ];
        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions->toArray());

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
        $role = Role::create(['name' => 'pharmacist'])
            ->givePermissionTo([
                'view-categories',
                'view-distributions',
                'view-reports',
                'view-distribution-barangay',
                'view-medicines',
                'view-patients',
                'view-barangays',
                'view-schedules',
                'view-expired',
                'view-out-of-stock',
                'view-admin_inventory',
                'view-admin_manage',
                'view-admin_distributions',
            ]);

        $role = Role::create(['name' => 'bhw'])
            ->givePermissionTo([
                'view-bhw_inventory',
                'view-bhw_manage',
                'view-bhw_distributions',
                'view-barangay_medicines',
                'view-barangay_out-of-stock',
                'view-barangay_expired',
                'view-barangay_distributions',
                'view-barangay_patients',
            ]);
    }
}
