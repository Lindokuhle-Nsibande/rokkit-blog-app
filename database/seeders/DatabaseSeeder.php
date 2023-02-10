<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Controllers\BlogController;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $file = new Filesystem;
        $file->cleanDirectory(BlogController::customePublic_path('assets/img/thumbnails'));
        Category::truncate();

        Category::create([
            'name' => 'Business',
            'name_slug' => 'business' 
        ]);
        Category::create([
            'name' => 'Technology',
            'name_slug' => 'technology' 
        ]);
        Category::create([
            'name' => 'Health',
            'name_slug' => 'health' 
        ]);
    }
}
