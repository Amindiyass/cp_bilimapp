<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_history', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->foreignId('user_id')
                ->constrained('users');
            $table->foreignId('operation_id')
                ->constrained('operations');
            $table->foreignId('operation_type_id')
                ->constrained('operation_types');
            $table->integer('balance_before');
            $table->integer('balance_after');
            $table->integer('balance_in_block');
            $table->timestamps();
            $table->index(['user_id', 'operation_id', 'operation_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balance_history');
    }
}
