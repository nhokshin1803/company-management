<?php

namespace Database\Seeders;

use App\Models\Board;
use Illuminate\Database\Seeder;

class BoardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Board::truncate();

        $faker = \Faker\Factory::create();

        //create Boards in database:
        // for ($i = 0; $i < 50; $i++) {
        //     Board::create([
        //     ]);
        // }
    }
}
