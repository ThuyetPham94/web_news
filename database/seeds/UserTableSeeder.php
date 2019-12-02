<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Pham',
            'email' => 'admin@test.com',
            'password' => Hash::make('123456'),
            'created_at' => date("Y-m-d H:i:s")
        ]);
    }
}
