<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title_kz');
            $table->string('title_ru');
            $table->foreignId('lesson_id')
                ->constrained('lessons');
            $table->foreignId('subject_id')
                ->constrained('subjects');
            $table->string('path');
            $table->integer('sort_number');
            $table->timestamps();
            $table->index(['lesson_id', 'subject_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
