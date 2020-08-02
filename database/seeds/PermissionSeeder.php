<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['title' => 'show-roles','label' => 'مدیریت سمت ها و مجوزها','created_at' => \Carbon\Carbon::now()],
            ['title' => 'show-users','label' => 'مدیریت کاربران','created_at' => \Carbon\Carbon::now()],
            ['title' => 'show-categories','label' => 'مدیریت دسته ها','created_at' => \Carbon\Carbon::now()],
            ['title' => 'show-articles','label' => 'مدیریت مقالات','created_at' => \Carbon\Carbon::now()],
            ['title' => 'show-products','label' => 'مدیریت محصولات','created_at' => \Carbon\Carbon::now()],
            ['title' => 'show-videos','label' => 'مدیریت ویدئوها','created_at' => \Carbon\Carbon::now()],
            ['title' => 'show-comments','label' => 'مدیریت کامنت ها','created_at' => \Carbon\Carbon::now()]
        ];
        $permissionRoles = [
            ['role_id' => 1 , 'permission_id' => 1],
            ['role_id' => 1 , 'permission_id' => 2],
            ['role_id' => 1 , 'permission_id' => 3],
            ['role_id' => 1 , 'permission_id' => 4],
            ['role_id' => 1 , 'permission_id' => 5],
            ['role_id' => 1 , 'permission_id' => 6],
            ['role_id' => 1 , 'permission_id' => 7],
        ];
        DB::table('permissions')->insert($permissions) ;
        DB::table('permission_role')->insert($permissionRoles) ;
    }
}
