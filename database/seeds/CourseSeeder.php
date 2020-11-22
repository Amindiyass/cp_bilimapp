<?php

use App\Models\CompletedRate;
use App\Models\Course;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        Subject::create([
            'name_kz' => 'Матем',
            'name_ru' => 'Матем'
        ]);
        Course::create([
            'name_kz' => 'Матем',
            'name_ru' => 'Матем',
            'language_id' => 1,
            'subject_id' => 1,
            'class_id' => 1,
            'order' => 1,
            'description_kz' => 'Desc',
            'description_ru' => 'Desc',
        ]);
        CompletedRate::create([
            'model_type' => 'App\Models\Course',
            'model_id'   => 1,
            'rate'       => 50,
            'user_id'    => 1,
            'is_checked' => false
        ]);
        Section::create([
            'name_kz' => 'Theme kz',
            'name_ru' => 'Theme ru',
            'course_id' => 1,
            'sort_number' => 1
        ]);
    }
}
