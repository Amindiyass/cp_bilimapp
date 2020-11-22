<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        \App\Models\Language::create(
//            [
//                'name_kz' => 'Казак тили',
//                'name_ru' => 'Казахский язык',
//            ]);
//        \App\Models\Language::create(
//            [
//                'name_kz' => 'Орыс тили',
//                'name_ru' => 'Руский язык',
//            ]);

        factory(App\Models\Area::class, 10)->create();
        factory(App\Models\Region::class, 10)->create();
        factory(App\Models\School::class, 10)->create();
//        factory(App\User::class, 20)->create();
//        factory(App\Models\Subject::class, 20)->create();
//        factory(App\Models\EducationLevel::class, 11)->create();
//        factory(App\Models\Course::class, 30)->create();
//        factory(App\Models\Section::class, 100)->create();
//        factory(App\Models\Lesson::class, 200)->create();
//        factory(App\Models\Test::class, 300)->create();
//        factory(App\Models\Assignment::class, 300)->create();
//        factory(App\Models\Video::class, 300)->create();

    }
}
