<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Post::factory(50)->create();
        Author::factory(5)->create();
        Category::create([
            'name' => 'Kesehatan',
            'slug' => "kesehatan"
        ]);
        Category::create([
            'name' => 'Sepak Bola',
            'slug' => "sepak-bola"
        ]);
        Category::create([
            'name' => 'Teknologi',
            'slug' => "teknologi"
        ]);
        Category::create([
            'name' => 'Politik',
            'slug' => "politik"
        ]);
        Category::create([
            'name' => 'Pendidikan',
            'slug' => "pendidikan"
        ]);
    }
}