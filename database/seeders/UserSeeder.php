<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $devRole = Role::where('name', 'developer')->first();
        $testerRole = Role::where('name', 'tester')->first();

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bugtracker.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'John Developer',
            'email' => 'dev1@bugtracker.com',
            'password' => bcrypt('password'),
            'role_id' => $devRole->id,
        ]);

        User::create([
            'name' => 'Jane Developer',
            'email' => 'dev2@bugtracker.com',
            'password' => bcrypt('password'),
            'role_id' => $devRole->id,
        ]);

        User::create([
            'name' => 'Alice Tester',
            'email' => 'tester1@bugtracker.com',
            'password' => bcrypt('password'),
            'role_id' => $testerRole->id,
        ]);

        User::create([
            'name' => 'Bob Tester',
            'email' => 'tester2@bugtracker.com',
            'password' => bcrypt('password'),
            'role_id' => $testerRole->id,
        ]);
    }
}
