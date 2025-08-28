<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Branch;
use App\Models\TableService;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Branch::firstOrCreate([
            'name' => 'SM Butuan',
            'location' => 'Butuan City, Agusan del Norte, Philippines'
        ]);

        $services = ['Cleaning', 'Billing', 'Call Support', 'Service Water'];

        foreach ($services as $name) {
            TableService::firstOrCreate(['name' => $name]);
        }

        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]
        );

        $this->setupRolesAndPermissions();
    }

    protected function setupRolesAndPermissions() {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $user = User::where(['is_admin' => true])->first();
        /*
        |--------------------------------------------------------------------------
        | Define Permissions
        |--------------------------------------------------------------------------
        */
        $permissions = [
            // Users
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            // Roles
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'roles.assign',
            'roles.remove',
            // assign permission to role
            'permissions.assign',
            'permissions.remove',
            // Menus
            // 'menus.view',
            // 'menus.create',
            // 'menus.edit',
            // 'menus.delete',
            // 'menus.upload.image',
            // Orders
            // 'orders.view',
            // 'orders.create',
            // 'orders.edit',
            // 'orders.delete',
            // 'orders.cancel',
            // 'orders.complete',
            // 'orders.void',
            // Device
            'devices.view',
            'devices.register',
            'devices.assign.table',
            'devices.unassign.table',
            'devices.delete',
             // Branch
            'branches.view',
            'branches.create',
            'branches.edit',
            'branches.delete',
            // Reports
            'reports.sales.view',
            'reports.sales.export',  
            'reports.revenue.view',
            'reports.revenue.export',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        /*
        |--------------------------------------------------------------------------
        | Define Roles & Assign Permissions
        |--------------------------------------------------------------------------
        */
        $owner = Role::firstOrCreate(['name' => 'Owner']);
        $accountant = Role::firstOrCreate(['name' => 'Accountant']);
        $marketer = Role::firstOrCreate(['name' => 'Marketer']);
        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $staff = Role::firstOrCreate(['name' => 'Staff']);

        $owner->givePermissionTo(Permission::all());
        $accountant->givePermissionTo(['reports.sales.view', 'reports.sales.export', 'reports.revenue.view', 'reports.revenue.export']);
        $manager->givePermissionTo([
            // 'orders.view', 'orders.create', 'orders.edit', 'orders.delete', 'orders.cancel', 'orders.complete', 'orders.void',
            // 'devices.view', 'devices.register', 'devices.assign.table', 'devices.unassign.table', 'devices.delete',
            'branches.view', 'branches.create', 'branches.edit', 'branches.delete',
            'reports.sales.view', 'reports.sales.export',
            // 'menus.view', 'menus.create', 'menus.edit', 'menus.delete', 'menus.upload.image',
            'users.view', 'users.create', 'users.edit', 'users.delete',
        ]);
        // 
        $user->assignRole($owner);


    }
}
