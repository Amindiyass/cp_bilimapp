<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Language::create(
            [
                'name_kz' => 'Казак тили',
                'name_ru' => 'Казахский язык',
            ],
            [
                'name_kz' => 'Казак тили',
                'name_ru' => 'Казахский язык',
            ]
        );
    }
}
