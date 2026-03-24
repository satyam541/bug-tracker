<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@bugtracker.com')->first();
        $allUsers = User::all();

        $project1 = Project::create([
            'name' => 'E-Commerce Platform',
            'description' => 'An online shopping platform with cart, checkout, payment integration, and order tracking.',
            'status' => 'active',
            'created_by' => $admin->id,
        ]);
        $project1->members()->attach($allUsers->pluck('id'));

        $project2 = Project::create([
            'name' => 'Student Management System',
            'description' => 'A system to manage student records, attendance, grades, and course registrations.',
            'status' => 'active',
            'created_by' => $admin->id,
        ]);
        $project2->members()->attach($allUsers->pluck('id'));
    }
}
