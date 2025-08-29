<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // Permissions
        $permissions = [
            'event.view',
            'event.create',
            'event.update',
            'event.delete',
            'booking.view',
            'booking.create',
            'booking.cancel',
            'user.manage',
        ];

        foreach ($permissions as $permission){
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api',
            ]);
        }

        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'superAdmin', 'guard_name' => 'api']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        $user = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'api']);

        // Assign permissions to roles
        $superAdmin->givePermissionTo(Permission::all());

        $admin->givePermissionTo([
            'event.view',
            'event.create',
            'event.update',
            'event.delete',
            'booking.view',
            'user.manage',
        ]);

        $user->givePermissionTo([
            'event.view',
            'booking.create',
            'booking.view',
            'booking.cancel',
        ]);
    }
}
