<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // Permission Event
        $permissions = [
            'event.view',
            'event.create',
            'event.update',
            'event.delete',
            'admin.create',
        ];

        foreach ($permissions as $permission){
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);


        //Super Admin Permission
        $superAdmin->givePermissionTo(Permission::all());
        //Admin Permission
        $admin->givePermissionTo([
            'event.view',
            'event.create',
            'event.update',
            'event.delete',
        ]);

        //User Permission
        $user->givePermissionTo([
            'event.view',
        ]);
    }
}
