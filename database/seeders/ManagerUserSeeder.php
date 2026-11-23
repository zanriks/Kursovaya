<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class ManagerUserSeeder extends Seeder
{
    public function run(): void
    {
        $managerRole = Role::firstOrCreate(['name' => 'manager']);

        User::updateOrCreate(
            ['login' => 'manager'],
            [
                'role_id' => $managerRole->role_id,
                'last_name' => 'Менеджер',
                'first_name' => 'astmaster',
                'email' => 'manager@astmaster.local',
                'password_hash' => 'manager12345',
                'is_active' => true,
            ]
        );
    }
}
