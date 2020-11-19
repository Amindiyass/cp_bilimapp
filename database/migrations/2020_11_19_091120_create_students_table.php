<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->foreignId('area_id')
                ->constrained('areas');
            $table->foreignId('region_id')
                ->constrained('regions');
            $table->foreignId('school_id')
                ->constrained('schools');
            $table->foreignId('language_id')
                ->constrained('languages');
            $table->foreignId('user_id')
                ->constrained('users');
            $table->timestamps();
            $table->index([
                'region_id',
                'area_id',
                'school_id',
                'language_id',
                'user_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
