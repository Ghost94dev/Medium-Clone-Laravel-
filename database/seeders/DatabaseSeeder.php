<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->create([
                'name' => 'John Doe',
                'username'=>'Johndoe',
                'email' => 'john@example.com',
            ]);

       $categories=[
        'Technology',
        'Health',
        'Travel',
        'Food',
        'Lifestyle',
        'Education',
        'Finance',
        'Entertainment',
        'Sports',
        'Science'
       ];

       foreach ($categories as $category) {
        \App\Models\Category::create([
            'name'=>$category]);
       }

       //Post::factory(50)->create();
    }
}
