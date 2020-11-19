<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('name_kz');
            $table->string('name_ru');
            $table->time('duration');
            $table->foreignId('lesson_id')
                ->constrained('lessons');
            $table->foreignId('subject_id')
                ->constrained('subjects');
            $table->timestamp('from_time');
            $table->timestamp('till_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
