<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')
                ->constrained('tests');
            $table->foreignId('user_id')
                ->constrained('users');
            $table->integer('total_question');
            $table->integer('wrong_answered');
            $table->integer('right_answered');
            $table->boolean('passed');
            $table->timestamps();
            $table->index(['user_id', 'test_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_results');
    }
}
