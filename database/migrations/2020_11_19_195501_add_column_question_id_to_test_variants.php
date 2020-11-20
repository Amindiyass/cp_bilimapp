<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnQuestionIdToTestVariants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_variants', function (Blueprint $table) {
            $table->foreignId('question_id')
                ->constrained('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_variants', function (Blueprint $table) {
            $table->dropForeign('test_variants_question_id_foreign');
            $table->dropColumn('question_id');
        });
    }
}
