<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => hash::make('password'), // Use a secure password
            ]
        );
        // Pastikan role sudah ada
        $role = Role::firstOrCreate(['name' => 'super-admin']);

        // Assign role ke user
        if (!$superAdmin->hasRole('super-admin')) {
            $superAdmin->assignRole($role);
        }
    }
}
