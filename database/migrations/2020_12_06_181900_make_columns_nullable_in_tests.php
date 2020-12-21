<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeColumnsNullableInTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->time('duration')
                ->nullable()
                ->change();

            $table->dateTime('from_time')
                ->nullable()
                ->change();

            $table->dateTime('till_time')
                ->nullable()
                ->change();

            $table->foreignId('lesson_id')
                ->nullable()
                ->change();
            $table->foreignId('subject_id')
                ->nullable()
                ->change();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tests', function (Blueprint $table) {
            //
        });
    }
}
