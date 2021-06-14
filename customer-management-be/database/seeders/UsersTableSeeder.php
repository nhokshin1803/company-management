<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Post::truncate();

        $faker = \Faker\Factory::create();

        //create posts in database:
        // for ($i = 0; $i < 50; $i++) {
        //     Post::create([
        //     ]);
        // }
    }
}
