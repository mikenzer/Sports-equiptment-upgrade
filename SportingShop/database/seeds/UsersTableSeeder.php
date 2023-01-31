<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\Roles;
use App\admin_roles;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();
        admin_roles::truncate();
        $adminRoles = Roles::where('name', 'admin')->first();
        
        $userRoles = Roles::where('name', 'user')->first();

        $admin = Admin::create([
            'admin_name' => 'nhanadmin',
            'admin_email' => 'admin@gmail.com',
            'admin_phone' => '0379530595',
            'admin_password' => md5('123456')
        ]);

        
        $user = Admin::create([
            'admin_name' => 'nhanuser',
            'admin_email' => 'admin2@gmail.com',
            'admin_phone' => '0379530595',
            'admin_password' => md5('123456')
        ]);

        $admin->roles()->attach($adminRoles);
        
        $user->roles()->attach($userRoles);
    }
}
