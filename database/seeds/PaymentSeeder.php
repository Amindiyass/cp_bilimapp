<?php

use App\Models\BalanceHistory;
use App\Models\Operation;
use App\Models\OperationType;
use App\Models\Payment;
use App\Models\PaymentStatus;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentStatus::insert([
            ['name' => 'error'],
            ['name' => 'created'],
            ['name' => 'success']
        ]);
        Operation::create([
            'name_kz' => 'Opeartion 1',
            'name_ru' => 'Operation 1'
        ]);
        OperationType::create([
            'name_kz' => 'withdraw',
            'name_ru' => 'withdraw',
        ]);
        BalanceHistory::create([
            'status' => 1,
            'user_id' => 1,
            'operation_id' => 1,
            'operation_type_id' => 1,
            'balance_before' => 0,
            'balance_after' => 10,
            'balance_in_block' => 0
        ]);
        factory(Payment::class, 2)->create();
    }
}
