<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixVideosConspectus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conspectuses', function (Blueprint $table) {
            $table->foreignId('video_id')
                ->constrained('videos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('conspectuses', function (Blueprint $table) {
            $table->dropColumn('video_id');
        });
    }
}
