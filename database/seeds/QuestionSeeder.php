<?php


use App\Models\Question;
use App\Models\TestVariant;

class QuestionSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        factory(Question::class, 2)->create()->each(function (Question $question) {
            $question->variants()->save(factory(TestVariant::class)->make(['question_id' => $question->id]));
        });
    }
}
