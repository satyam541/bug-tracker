<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Bug;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@bugtracker.com')->first();
        $dev1 = User::where('email', 'dev1@bugtracker.com')->first();
        $tester1 = User::where('email', 'tester1@bugtracker.com')->first();

        $projects = Project::all();
        $bugs = Bug::all();

        $logs = [
            ['user_id' => $admin->id, 'action' => 'project_created', 'description' => "Project 'E-Commerce Platform' was created.", 'subject_type' => Project::class, 'subject_id' => $projects[0]->id],
            ['user_id' => $admin->id, 'action' => 'project_created', 'description' => "Project 'Student Management System' was created.", 'subject_type' => Project::class, 'subject_id' => $projects[1]->id],
            ['user_id' => $tester1->id, 'action' => 'bug_created', 'description' => "Bug 'Login page crashes on mobile' was created.", 'subject_type' => Bug::class, 'subject_id' => $bugs[0]->id],
            ['user_id' => $admin->id, 'action' => 'bug_assigned', 'description' => "Bug 'Login page crashes on mobile' was assigned to John Developer.", 'subject_type' => Bug::class, 'subject_id' => $bugs[0]->id],
            ['user_id' => $tester1->id, 'action' => 'bug_created', 'description' => "Bug 'Cart total not updating' was created.", 'subject_type' => Bug::class, 'subject_id' => $bugs[1]->id],
            ['user_id' => $dev1->id, 'action' => 'bug_status_changed', 'description' => "Bug 'Cart total not updating' status changed to 'In Progress'.", 'subject_type' => Bug::class, 'subject_id' => $bugs[1]->id],
            ['user_id' => $dev1->id, 'action' => 'comment_added', 'description' => "Comment added on bug 'Login page crashes on mobile'.", 'subject_type' => Bug::class, 'subject_id' => $bugs[0]->id],
            ['user_id' => $admin->id, 'action' => 'user_created', 'description' => "User 'John Developer' was created.", 'subject_type' => User::class, 'subject_id' => $dev1->id],
        ];

        foreach ($logs as $log) {
            ActivityLog::create($log);
        }
    }
}
