<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeVariantInInTestVariants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_variants', function (Blueprint $table) {
            $table->longText('variant_in_kz')->nullable()->change();
            $table->longText('variant_in_ru')->nullable()->change();
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
            $table->string('variant_in_kz')->nullable()->change();
            $table->string('variant_in_ru')->nullable()->change();
        });
    }
}
