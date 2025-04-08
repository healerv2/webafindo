<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Create Permissions
        Permission::create(['name' => 'view role']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'delete role']);

        Permission::create(['name' => 'view permission']);
        Permission::create(['name' => 'create permission']);
        Permission::create(['name' => 'update permission']);
        Permission::create(['name' => 'delete permission']);

        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);

        Permission::create(['name' => 'view data paket']);
        Permission::create(['name' => 'create data paket']);
        Permission::create(['name' => 'update data paket']);
        Permission::create(['name' => 'delete data paket']);

        Permission::create(['name' => 'view data area']);
        Permission::create(['name' => 'create data area']);
        Permission::create(['name' => 'update data area']);
        Permission::create(['name' => 'delete data area']);

        Permission::create(['name' => 'view manage pelanggan']);

        Permission::create(['name' => 'view mikrotik']);
        Permission::create(['name' => 'create mikrotik']);
        Permission::create(['name' => 'update mikrotik']);
        Permission::create(['name' => 'delete mikrotik']);

        Permission::create(['name' => 'view customer']);
        Permission::create(['name' => 'create customer']);
        Permission::create(['name' => 'update customer']);
        Permission::create(['name' => 'delete customer']);

        // Create Roles
        $superAdminRole = Role::create(['name' => 'super-admin']); //as super-admin
        $adminRole = Role::create(['name' => 'admin']);
        $staffRole = Role::create(['name' => 'Customer']);
        //$userRole = Role::create(['name' => 'Customer']);

        // Lets give all permission to super-admin role.
        $allPermissionNames = Permission::pluck('name')->toArray();

        $superAdminRole->givePermissionTo($allPermissionNames);

        // Let's give few permissions to admin role.
        $adminRole->givePermissionTo(['create role', 'view role', 'update role']);
        $adminRole->givePermissionTo(['create permission', 'view permission']);
        $adminRole->givePermissionTo(['create user', 'view user', 'update user']);

        // Let's Create User and assign Role to it.

        $superAdminUser = User::firstOrCreate([
            'email' => 'superadmin@gmail.com',
        ], [
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
            'foto'      => 'user.jpg',
        ]);

        $superAdminUser->assignRole($superAdminRole);


        $adminUser = User::firstOrCreate([
            'email' => 'admin@gmail.com'
        ], [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'foto'      => 'user.jpg',
        ]);

        $adminUser->assignRole($adminRole);


        $staffUser = User::firstOrCreate([
            'email' => 'staff@gmail.com',
        ], [
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'password' => Hash::make('12345678'),
            'foto'      => 'user.jpg',
        ]);

        $staffUser->assignRole($staffRole);
    }
}
