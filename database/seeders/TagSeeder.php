<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Exam',        'color' => '#ef4444'],
            ['name' => 'Homework',    'color' => '#3b82f6'],
            ['name' => 'Project',     'color' => '#8b5cf6'],
            ['name' => 'Reading',     'color' => '#10b981'],
            ['name' => 'Group Work',  'color' => '#f59e0b'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag['name']], ['color' => $tag['color']]);
        }
    }
}
