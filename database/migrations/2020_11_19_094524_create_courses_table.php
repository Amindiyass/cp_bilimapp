<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name_ru');
            $table->string('name_kz');
            $table->foreignId('language_id')
                ->constrained('languages');

            $table->foreignId('subject_id')
                ->constrained('subjects');

            $table->foreignId('class_id')
                ->constrained('education_levels');

            $table->integer('order');
            $table->text('description_ru');
            $table->text('description_kz');
            $table->timestamps();
            $table->index(['language_id', 'subject_id', 'class_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
