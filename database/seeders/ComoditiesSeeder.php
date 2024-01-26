<?php

namespace Database\Seeders;

use App\Models\Comodities;
use Illuminate\Database\Seeder;

class ComoditiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comodities::factory(10)->create();
    }
}
