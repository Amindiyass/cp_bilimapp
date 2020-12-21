<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSectionIdToTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->unsignedBigInteger('section_id')->nullable();
            $table->foreign('section_id')->references('id')->on('sections');
            $table->index('section_id');
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
            $table->dropForeign('tests_section_id_foreign');
            $table->dropIndex('tests_section_id_index');
            $table->dropColumn('section_id');

        });
    }
}
