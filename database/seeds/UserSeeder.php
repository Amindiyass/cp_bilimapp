<?php


use App\Models\CompletedRate;
use App\Models\Student;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        factory(User::class, 2)->create()->each(function ($user) {
            $user->students()->save(factory(Student::class)->make());
            factory(CompletedRate::class)->create(['model_type' => 'App\Models\Lesson', 'user_id' => $user->id]);
            factory(CompletedRate::class)->create(['model_type' => 'App\Models\Course', 'user_id' => $user->id]);
            factory(CompletedRate::class)->create(['model_type' => 'App\Models\Video', 'user_id' => $user->id]);
            factory(CompletedRate::class)->create(['model_type' => 'App\Models\Conspectus', 'user_id' => $user->id]);
            factory(CompletedRate::class)->create(['model_type' => 'App\Models\Test', 'user_id' => $user->id]);
        });
//        Student::create([
//            'first_name' => 'First Name',
//            'last_name' => 'Last name',
//            'area_id' => 1,
//            'region_id' => 1,
//            'school_id' => 1,
//            'language_id' => 1,
//            'user_id' => $user->id,
//            'class_id' => 1
//        ]);
    }
}
