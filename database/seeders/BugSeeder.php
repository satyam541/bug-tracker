<?php

namespace Database\Seeders;

use App\Models\Bug;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class BugSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();
        $dev1 = User::where('email', 'dev1@bugtracker.com')->first();
        $dev2 = User::where('email', 'dev2@bugtracker.com')->first();
        $tester1 = User::where('email', 'tester1@bugtracker.com')->first();
        $tester2 = User::where('email', 'tester2@bugtracker.com')->first();

        $bugs = [
            [
                'title' => 'Login page crashes on mobile',
                'description' => 'The login page throws a JavaScript error on mobile browsers. Form submission fails and shows a blank white screen.',
                'project_id' => $projects[0]->id,
                'reporter_id' => $tester1->id,
                'assigned_to' => $dev1->id,
                'status' => 'open',
                'priority' => 'high',
                'severity' => 'major',
            ],
            [
                'title' => 'Cart total not updating',
                'description' => 'When items are added or removed from the cart, the total amount does not update until page refresh.',
                'project_id' => $projects[0]->id,
                'reporter_id' => $tester2->id,
                'assigned_to' => $dev1->id,
                'status' => 'in_progress',
                'priority' => 'critical',
                'severity' => 'critical',
            ],
            [
                'title' => 'Payment gateway timeout',
                'description' => 'Payment processing times out after 30 seconds during peak hours. Customers see an error page.',
                'project_id' => $projects[0]->id,
                'reporter_id' => $tester1->id,
                'assigned_to' => $dev2->id,
                'status' => 'open',
                'priority' => 'critical',
                'severity' => 'critical',
            ],
            [
                'title' => 'Search results show deleted products',
                'description' => 'Products that have been marked as deleted still appear in search results.',
                'project_id' => $projects[0]->id,
                'reporter_id' => $tester2->id,
                'assigned_to' => $dev2->id,
                'status' => 'fixed',
                'priority' => 'medium',
                'severity' => 'minor',
            ],
            [
                'title' => 'Order confirmation email not sent',
                'description' => 'After successful checkout, users do not receive the order confirmation email.',
                'project_id' => $projects[0]->id,
                'reporter_id' => $tester1->id,
                'assigned_to' => $dev1->id,
                'status' => 'closed',
                'priority' => 'high',
                'severity' => 'major',
            ],
            [
                'title' => 'Student registration form validation missing',
                'description' => 'The registration form allows submission without required fields like name and email.',
                'project_id' => $projects[1]->id,
                'reporter_id' => $tester2->id,
                'assigned_to' => $dev1->id,
                'status' => 'open',
                'priority' => 'medium',
                'severity' => 'major',
            ],
            [
                'title' => 'Attendance report shows wrong dates',
                'description' => 'The attendance report displays dates one day ahead of the actual attendance date.',
                'project_id' => $projects[1]->id,
                'reporter_id' => $tester1->id,
                'assigned_to' => $dev2->id,
                'status' => 'in_progress',
                'priority' => 'high',
                'severity' => 'major',
            ],
            [
                'title' => 'Grade calculation error for weighted courses',
                'description' => 'Weighted average grades are calculated incorrectly when a student has courses with different credit hours.',
                'project_id' => $projects[1]->id,
                'reporter_id' => $tester2->id,
                'assigned_to' => $dev1->id,
                'status' => 'open',
                'priority' => 'high',
                'severity' => 'critical',
            ],
            [
                'title' => 'Profile picture upload fails for PNG',
                'description' => 'Students cannot upload PNG profile pictures. Only JPEG files are accepted.',
                'project_id' => $projects[1]->id,
                'reporter_id' => $tester1->id,
                'assigned_to' => null,
                'status' => 'open',
                'priority' => 'low',
                'severity' => 'minor',
            ],
            [
                'title' => 'Course dropdown empty on enrollment page',
                'description' => 'The course selection dropdown on the enrollment page is empty. Students cannot enroll in any courses.',
                'project_id' => $projects[1]->id,
                'reporter_id' => $tester2->id,
                'assigned_to' => $dev2->id,
                'status' => 'fixed',
                'priority' => 'critical',
                'severity' => 'critical',
            ],
        ];

        foreach ($bugs as $bug) {
            Bug::create($bug);
        }
    }
}
