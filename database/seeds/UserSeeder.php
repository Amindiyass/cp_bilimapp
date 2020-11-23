<?php


use App\Models\Student;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'User 1',
            'email' => 'user@app.com',
            'password' => Hash::make('password'),
            'is_active' => true,
            'balance' => 0,
            'phone' => '77770667303'
        ]);
        Student::create([
            'first_name' => 'First Name',
            'last_name' => 'Last name',
            'area_id' => 1,
            'region_id' => 1,
            'school_id' => 1,
            'language_id' => 1,
            'user_id' => $user->id,
            'class_id' => 1
        ]);
    }
}
