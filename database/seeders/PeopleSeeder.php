<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\People::factory(10)->create();
    }
}
