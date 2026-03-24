<?php

namespace Database\Seeders;

use App\Models\Bug;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $dev1 = User::where('email', 'dev1@bugtracker.com')->first();
        $dev2 = User::where('email', 'dev2@bugtracker.com')->first();
        $tester1 = User::where('email', 'tester1@bugtracker.com')->first();
        $admin = User::where('email', 'admin@bugtracker.com')->first();

        $bugs = Bug::all();

        $comments = [
            ['bug_id' => $bugs[0]->id, 'user_id' => $dev1->id, 'body' => 'I can reproduce this issue. Looks like a CSS viewport issue. Working on a fix.'],
            ['bug_id' => $bugs[0]->id, 'user_id' => $tester1->id, 'body' => 'This happens on both Chrome and Safari mobile browsers.'],
            ['bug_id' => $bugs[1]->id, 'user_id' => $dev1->id, 'body' => 'Found the issue. The AJAX call is not refreshing the totals. Fixing now.'],
            ['bug_id' => $bugs[2]->id, 'user_id' => $dev2->id, 'body' => 'This seems to be a timeout configuration issue with the payment API.'],
            ['bug_id' => $bugs[2]->id, 'user_id' => $admin->id, 'body' => 'This is critical. Please prioritize this fix.'],
            ['bug_id' => $bugs[4]->id, 'user_id' => $dev1->id, 'body' => 'Fixed the SMTP configuration. Emails are sending correctly now.'],
            ['bug_id' => $bugs[5]->id, 'user_id' => $dev1->id, 'body' => 'I will add proper validation rules to all required fields.'],
            ['bug_id' => $bugs[6]->id, 'user_id' => $dev2->id, 'body' => 'The timezone configuration was wrong. Fixing the date calculation.'],
            ['bug_id' => $bugs[7]->id, 'user_id' => $tester1->id, 'body' => 'Students are getting incorrect GPAs because of this issue.'],
            ['bug_id' => $bugs[9]->id, 'user_id' => $dev2->id, 'body' => 'The API endpoint for courses was returning empty. Fixed the query.'],
        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }
    }
}
