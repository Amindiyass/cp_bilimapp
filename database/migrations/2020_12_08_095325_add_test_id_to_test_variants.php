<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTestIdToTestVariants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_variants', function (Blueprint $table) {
            $table->foreignId('test_id')
                ->constrained('tests');
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
            $table->dropForeign('test_variants_test_id_foreign');
            $table->dropColumn('test_id');
        });
    }
}
