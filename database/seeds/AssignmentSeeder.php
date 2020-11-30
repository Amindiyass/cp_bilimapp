<?php

use App\Models\Assignment;
use App\Models\AssignmentSolution;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Assignment::class, 5)->create()->each(function($assigment) {
            $assigment->solution()->save(factory(AssignmentSolution::class)->make());
        });
    }
}
