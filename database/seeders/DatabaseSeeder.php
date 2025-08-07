<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        RoleAndPermissionSeeder::class,
        SuperAdminSeeder::class,
    ]);

        $user = User::firstOrCreate([
            'email' => 'admin1123@example.com'],
            [
                'name' => 'Admin1',
                'password' => hash::make('password'),
            ]
        );

        $user->assignRole('admin');
    }
}
