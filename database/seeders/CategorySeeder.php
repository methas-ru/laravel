<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Work', 'description' => 'Related to professional tasks'],
            ['name' => 'Personal', 'description' => 'Private life and hobbies'],
            ['name' => 'Travel', 'description' => 'Trips and adventures'],
            ['name' => 'Food', 'description' => 'Dining and cooking'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat['name']], $cat);
        }
    }
}