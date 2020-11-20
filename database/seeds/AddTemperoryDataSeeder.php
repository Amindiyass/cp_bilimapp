<?php

use Illuminate\Database\Seeder;

class AddTemperoryDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Area::create([
            'id' => 1,
            'name_kz' => 'area_1',
            'name_ru' => 'area_2',
        ]);
        \App\Models\Region::create([
            'id' => 1,
            'name_ru' => 'region_1',
            'name_kz' => 'region_1',
            'area_id' => 1,
        ]);
        \App\Models\School::create([
            'id' => 1,
            'name_ru' => 'school_1',
            'name_kz' => 'school_1',
            'region_id' => 1,
        ]);

        \App\Models\Language::create([
            'id' => 1,
            'name_ru' => 'language_1',
            'name_kz' => 'language_1',
        ]);

        \App\Models\EducationLevel::create([
            'id' => 1,
            'name_ru' => 'school_1',
            'name_kz' => 'school_1',
            'order_number' => 1,
        ]);



    }
}
