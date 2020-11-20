<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->nullable()->after('password');
            $table->integer('balance')->nullable()->after('is_active');
            $table->timestamp('last_visit')->nullable()->after('balance');
            $table->string('avatar_image')->nullable()->after('last_visit')->default('default.png');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_active',
                'balance',
                'last_visit',
                'avatar_image'
            ]);
        });
    }
}
