<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balance_history_id')
                ->constrained('balance_history');
            $table->integer('balance');
            $table->foreignId('user_id')
                ->constrained('users');
            $table->foreignId('subscription_id')
                ->constrained('subscriptions');
            $table->string('comment');
            $table->foreignId('status_id')
                ->constrained('payment_statuses');
            $table->json('check_response');
            $table->json('pay_response');
            $table->timestamps();
            $table->index([
                'balance_history_id',
                'user_id',
                'subscription_id',
                'created_at'
            ], 'payments_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
