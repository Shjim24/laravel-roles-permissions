<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Schema;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'admin-access',
            'super-admin-access'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Super Admin Role
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Create Admin Role
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo([
            'user-list',
            'user-create',
            'user-edit',
            'role-list',
            'permission-list',
            'admin-access'
        ]);

        // Check if status column exists
        $hasStatusColumn = Schema::hasColumn('users', 'status');
        
        // Create Super Admin User
        $superAdminData = [
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now()
        ];
        
        if ($hasStatusColumn) {
            $superAdminData['status'] = 'active';
        }
        
        $superAdmin = User::create($superAdminData);
        $superAdmin->assignRole($superAdminRole);

        // Create Admin User
        $adminData = [
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now()
        ];
        
        if ($hasStatusColumn) {
            $adminData['status'] = 'active';
        }
        
        $admin = User::create($adminData);
        $admin->assignRole($adminRole);
    }
}