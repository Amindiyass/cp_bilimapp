<?php


use App\Models\Conspectus;
use App\Models\Lesson;
use App\Models\Test;
use App\Models\Video;

class LessonSeader extends \Illuminate\Database\Seeder
{
    public function run()
    {
        Lesson::create([
            'name_kz' => 'Lesson 1',
            'name_ru' => 'Lesson 1',
            'section_id' => 1,
            'description_kz' => 'Desc',
            'description_ru' => 'Desc',
            'what_will_learn_kz' => 'What will learn',
            'what_will_learn_ru' => 'What will learn',
        ]);
        Video::create([
            'title_kz' => 'Video',
            'title_ru' => 'Video',
            'lesson_id' => 1,
            'subject_id' => 1,
            'path' => 's3://',
            'sort_number' => 1,
        ]);
        Conspectus::create([
            'body' => 'Conspect 1',
            'lesson_id' => 1
        ]);
        Test::create([
            'name_kz' => 'Test 1',
            'name_ru' => 'Test 1',
            'duration' => '90:00',
            'lesson_id' => 1,
            'subject_id' => 1,
            'from_time' => now(),
            'till_time' => now()->addHours(3)
        ]);
    }
}
