<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'demo@kiu.edu.ge'],
            ['name' => 'KIU Demo Student', 'password' => Hash::make('password')],
        );

        $today = Carbon::today();

        // Deadlines are relative to "today" so the list always has a realistic
        // spread (overdue / due today / this week / upcoming) instead of every
        // task showing up as overdue.
        $tasks = [
            [
                'title'       => 'Complete Midterm Project',
                'description' => 'Build a Laravel CRUD application for the midterm assignment.',
                'subject'     => 'Web Programming',
                'status'      => Task::PENDING,
                'priority'    => Task::HIGH,
                'deadline'    => $today->copy()->addDays(2),   // due this week
            ],
            [
                'title'       => 'Read Chapter 5 – Database Design',
                'description' => 'Cover normalization, ER diagrams, and relational schema.',
                'subject'     => 'Database Systems',
                'status'      => Task::PENDING,
                'priority'    => Task::HIGH,
                'deadline'    => $today->copy()->subDays(3),   // overdue
            ],
            [
                'title'       => 'Submit Lab Report #3',
                'description' => 'Document the results of the networking lab experiment.',
                'subject'     => 'Computer Networks',
                'status'      => Task::PENDING,
                'priority'    => Task::MEDIUM,
                'deadline'    => $today->copy(),               // due today
            ],
            [
                'title'       => 'Practice OOP Concepts',
                'description' => 'Write small programs demonstrating inheritance and polymorphism.',
                'subject'     => 'Object-Oriented Programming',
                'status'      => Task::DONE,
                'priority'    => Task::MEDIUM,
                'deadline'    => $today->copy()->subDays(10),  // done
            ],
            [
                'title'       => 'Prepare Presentation Slides',
                'description' => 'Create slides for the group project presentation.',
                'subject'     => 'Software Engineering',
                'status'      => Task::PENDING,
                'priority'    => Task::HIGH,
                'deadline'    => $today->copy()->addDays(5),   // upcoming
            ],
            [
                'title'       => 'Review Linear Algebra Notes',
                'description' => 'Go over eigenvalues, eigenvectors, and matrix transformations.',
                'subject'     => 'Mathematics',
                'status'      => Task::DONE,
                'priority'    => Task::LOW,
                'deadline'    => $today->copy()->subDays(15),  // done
            ],
            [
                'title'       => 'Write Essay on AI Ethics',
                'description' => 'Discuss the ethical implications of AI in society (1500 words).',
                'subject'     => 'Ethics in Computing',
                'status'      => Task::PENDING,
                'priority'    => Task::MEDIUM,
                'deadline'    => $today->copy()->addDays(12),  // upcoming
            ],
            [
                'title'       => 'Debug Sorting Algorithm',
                'description' => 'Fix the bug in the quicksort implementation for the assignment.',
                'subject'     => 'Data Structures & Algorithms',
                'status'      => Task::DONE,
                'priority'    => Task::HIGH,
                'deadline'    => $today->copy()->subDays(2),   // done
            ],
            [
                'title'       => 'Study for Networks Quiz',
                'description' => 'Revise OSI model, TCP/IP stack, and subnetting.',
                'subject'     => 'Computer Networks',
                'status'      => Task::PENDING,
                'priority'    => Task::HIGH,
                'deadline'    => $today->copy()->subDays(1),   // overdue
            ],
            [
                'title'       => 'Group Project Standup',
                'description' => 'Sync with the team on remaining backend tasks.',
                'subject'     => 'Software Engineering',
                'status'      => Task::PENDING,
                'priority'    => Task::LOW,
                'deadline'    => $today->copy()->addDays(1),   // due this week
            ],
            [
                'title'       => 'Update Portfolio Website',
                'description' => 'Add the new Laravel project to the personal portfolio.',
                'subject'     => 'Personal',
                'status'      => Task::PENDING,
                'priority'    => Task::LOW,
                'deadline'    => null,                          // no deadline
            ],
            [
                'title'       => 'Backup Project Repository',
                'description' => 'Push the latest changes and tag a release on GitHub.',
                'subject'     => 'Version Control',
                'status'      => Task::DONE,
                'priority'    => Task::MEDIUM,
                'deadline'    => $today->copy()->subDays(5),   // done
            ],
        ];

        $tagIds = Tag::pluck('id')->all();

        foreach ($tasks as $task) {
            $created = $user->tasks()->create($task);

            if (! empty($tagIds)) {
                $created->tags()->sync(
                    collect($tagIds)->random(rand(1, 2))->all()
                );
            }
        }
    }
}
