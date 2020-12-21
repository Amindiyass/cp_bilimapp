<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBodyKzBodyRuToQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('body');
            $table->longText('body_kz')->nullable();
            $table->longText('body_ru')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->text('body')->nullable();
            $table->dropColumn('body_kz');
            $table->dropColumn('body_ru');
        });
    }
}
