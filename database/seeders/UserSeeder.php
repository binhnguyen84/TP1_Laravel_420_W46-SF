<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name','admin')->first()->id;
        $memberRole = Role::where('name','member')->first()->id;

        //create new user as admin
        $user_admin = new User();
        $user_admin->id = 1;
        $user_admin->password= Hash::make('Passw0rd');
        $user_admin->email = 'admin1@example.com';
        $user_admin->last_name = 'admin';
        $user_admin->first_name = '1';
        $user_admin->role_id = $adminRole;        
        $user_admin ->save();
        
        //create new user as member
        $user_member = new User();
        $user_member->id = 2;
        $user_member->password= Hash::make('Passw0rd');
        $user_member->email = 'user1@example.com';
        $user_member->last_name = 'member';
        $user_member->first_name = '1';
        $user_member->role_id = $memberRole;
        $user_member ->save();

    }
}
