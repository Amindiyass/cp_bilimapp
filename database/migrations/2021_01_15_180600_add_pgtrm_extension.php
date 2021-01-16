<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
class AddPgtrmExtension extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS pg_trgm');
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP EXTENSION IF EXISTS pg_trgm');
    }
}
