<?php

namespace Database\Seeders;

use App\Models\TodoPriority;
use Illuminate\Database\Seeder;

class TodoPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TodoPriority::factory(5)->create();
    }
}
