<?php

use Illuminate\Database\Seeder;

class SoftDeleteAllTests extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tests = \App\Models\Test::all();
        foreach ($tests as $test) {
            $test->delete();
        }
    }
}
