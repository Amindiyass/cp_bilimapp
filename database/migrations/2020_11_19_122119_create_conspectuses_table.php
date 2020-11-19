<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConspectusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conspectuses', function (Blueprint $table) {
            $table->id();
            $table->longText('body');
            $table->foreignId('lesson_id')
                ->constrained('lessons');
            $table->timestamps();
            $table->index(['lesson_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conspectuses');
    }
}
