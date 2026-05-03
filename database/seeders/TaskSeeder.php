<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'title'       => 'Complete Midterm Project',
                'description' => 'Build a Laravel CRUD application for the midterm assignment.',
                'subject'     => 'Web Programming',
                'status'      => Task::PENDING,
                'priority'    => Task::HIGH,
                'deadline'    => '2026-05-01',
            ],
            [
                'title'       => 'Read Chapter 5 – Database Design',
                'description' => 'Cover normalization, ER diagrams, and relational schema.',
                'subject'     => 'Database Systems',
                'status'      => Task::PENDING,
                'priority'    => Task::HIGH,
                'deadline'    => '2026-05-08',
            ],
            [
                'title'       => 'Submit Lab Report #3',
                'description' => 'Document the results of the networking lab experiment.',
                'subject'     => 'Computer Networks',
                'status'      => Task::PENDING,
                'priority'    => Task::MEDIUM,
                'deadline'    => '2026-05-10',
            ],
            [
                'title'       => 'Practice OOP Concepts',
                'description' => 'Write small programs demonstrating inheritance and polymorphism.',
                'subject'     => 'Object-Oriented Programming',
                'status'      => Task::DONE,
                'priority'    => Task::MEDIUM,
                'deadline'    => '2026-05-12',
            ],
            [
                'title'       => 'Prepare Presentation Slides',
                'description' => 'Create slides for the group project presentation.',
                'subject'     => 'Software Engineering',
                'status'      => Task::PENDING,
                'priority'    => Task::HIGH,
                'deadline'    => '2026-05-15',
            ],
            [
                'title'       => 'Review Linear Algebra Notes',
                'description' => 'Go over eigenvalues, eigenvectors, and matrix transformations.',
                'subject'     => 'Mathematics',
                'status'      => Task::DONE,
                'priority'    => Task::LOW,
                'deadline'    => '2026-04-25',
            ],
            [
                'title'       => 'Write Essay on AI Ethics',
                'description' => 'Discuss the ethical implications of AI in society (1500 words).',
                'subject'     => 'Ethics in Computing',
                'status'      => Task::PENDING,
                'priority'    => Task::MEDIUM,
                'deadline'    => '2026-05-20',
            ],
            [
                'title'       => 'Debug Sorting Algorithm',
                'description' => 'Fix the bug in the quicksort implementation for the assignment.',
                'subject'     => 'Data Structures & Algorithms',
                'status'      => Task::DONE,
                'priority'    => Task::HIGH,
                'deadline'    => '2026-05-03',
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
