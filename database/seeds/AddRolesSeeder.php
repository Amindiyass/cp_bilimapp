<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AddRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin']);
        $role = Role::create(['name' => 'student']);
        $role = Role::create(['name' => 'moderator']);
        $role = Role::create(['name' => 'stuff']);
    }
}
