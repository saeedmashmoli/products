<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'Admin',
            'password' => bcrypt('123456'),
            'email' => 'saeedmashmoli@gmail.com',
            'role_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ]) ;
    }
}
