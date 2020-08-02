<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['title' => 'Admin','label' => 'ادمین','created_at' => \Carbon\Carbon::now()],
            ['title' => 'User','label' => 'کاربر','created_at' => \Carbon\Carbon::now()]
        ];
        DB::table('roles')->insert($roles) ;
    }
}
