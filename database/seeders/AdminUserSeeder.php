<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        User::updateOrCreate(
            ['login' => 'admin'],
            [
                'role_id' => $adminRole->role_id,
                'last_name' => 'Администратор',
                'first_name' => 'astmaster',
                'email' => 'admin@astmaster.local',
                'password_hash' => 'admin12345',
                'is_active' => true,
            ]
        );
    }
}