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
                'status'      => 'done',
                'priority'    => 'high',
                'deadline'    => '2026-05-05',
            ],
            [
                'title'       => 'Read Chapter 5 – Database Design',
                'description' => 'Cover normalization, ER diagrams, and relational schema.',
                'subject'     => 'Database Systems',
                'status'      => 'pending',
                'priority'    => 'high',
                'deadline'    => '2026-05-08',
            ],
            [
                'title'       => 'Submit Lab Report #3',
                'description' => 'Document the results of the networking lab experiment.',
                'subject'     => 'Computer Networks',
                'status'      => 'pending',
                'priority'    => 'medium',
                'deadline'    => '2026-05-10',
            ],
            [
                'title'       => 'Practice OOP Concepts',
                'description' => 'Write small programs demonstrating inheritance and polymorphism.',
                'subject'     => 'Object-Oriented Programming',
                'status'      => 'pending',
                'priority'    => 'medium',
                'deadline'    => '2026-05-12',
            ],
            [
                'title'       => 'Prepare Presentation Slides',
                'description' => 'Create slides for the group project presentation.',
                'subject'     => 'Software Engineering',
                'status'      => 'pending',
                'priority'    => 'high',
                'deadline'    => '2026-05-15',
            ],
            [
                'title'       => 'Review Linear Algebra Notes',
                'description' => 'Go over eigenvalues, eigenvectors, and matrix transformations.',
                'subject'     => 'Mathematics',
                'status'      => 'done',
                'priority'    => 'low',
                'deadline'    => '2026-04-30',
            ],
            [
                'title'       => 'Write Essay on AI Ethics',
                'description' => 'Discuss the ethical implications of AI in society (1500 words).',
                'subject'     => 'Ethics in Computing',
                'status'      => 'pending',
                'priority'    => 'medium',
                'deadline'    => '2026-05-20',
            ],
            [
                'title'       => 'Debug Sorting Algorithm',
                'description' => 'Fix the bug in the quicksort implementation for the assignment.',
                'subject'     => 'Data Structures & Algorithms',
                'status'      => 'done',
                'priority'    => 'high',
                'deadline'    => '2026-05-03',
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
