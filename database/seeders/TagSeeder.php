<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'work',
            'personal',
            'urgent',
            'low-priority',
            'bug',
            'feature',
            'design',
            'backend',
            'frontend',
            'research',
        ];

        foreach ($tags as $name) {
            Tag::firstOrCreate(['name' => $name]);
        }
    }
}
