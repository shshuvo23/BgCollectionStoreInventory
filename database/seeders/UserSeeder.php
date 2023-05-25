<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        $password1 = Hash::make('password');
        $password = Hash::make('12345678');
        $users = [
            ['name' => 'Head Office', 'role_id' => '1', 'email' => 'admin@gmail.com', 'email_verified_at' =>  $time, 'password' =>$password1, 'created_at' => $time],
            ['name' => 'MR', 'role_id' => '2', 'email' => 'mr@gmail.com', 'email_verified_at' =>  $time, 'password' =>$password1, 'created_at' => $time],
            ['name' => 'Rafiqul Hasan Shishir', 'role_id' => '6', 'email' => 'rafiqul@bgcollection.com.bd', 'email_verified_at' =>  $time, 'password' =>$password, 'created_at' => $time],
            ['name' => 'Faysal', 'role_id' => '6', 'email' => 'faysal@bgcollection.com.bd', 'email_verified_at' =>  $time, 'password' =>$password, 'created_at' => $time],
            ['name' => 'Rana', 'role_id' => '6', 'email' => 'rana@bgcollection.com.bd', 'email_verified_at' =>  $time, 'password' =>$password, 'created_at' => $time],
            ['name' => 'Ismail', 'role_id' => '2', 'email' => 'merchandiser6@bgcollection-bd.com', 'email_verified_at' =>  $time, 'password' =>$password, 'created_at' => $time],
            ['name' => 'Milon', 'role_id' => '2', 'email' => 'merchandiser3@bgcollection-bd.com', 'email_verified_at' =>  $time, 'password' =>$password, 'created_at' => $time],
            ['name' => 'Imran', 'role_id' => '2', 'email' => 'merchandiser1@bgcollection-bd.com', 'email_verified_at' =>  $time, 'password' =>$password, 'created_at' => $time],
            ['name' => 'Jannat', 'role_id' => '2', 'email' => 'merchandiser2@bgcollection-bd.com', 'email_verified_at' =>  $time, 'password' =>$password, 'created_at' => $time],
            ['name' => 'Nazmul', 'role_id' => '2', 'email' => 'piyas@bgcollection-bd.com', 'email_verified_at' =>  $time, 'password' =>$password, 'created_at' => $time],
            ['name' => 'Bari', 'role_id' => '2', 'email' => 'rifat@bgcollection-bd.com', 'email_verified_at' =>  $time, 'password' =>$password, 'created_at' => $time],
            ['name' => 'Amirul Islam', 'role_id' => '3', 'email' => 'store@gmail.com', 'email_verified_at' =>  $time, 'password' =>$password1, 'created_at' => $time],
            ['name' => 'Stock Out Name', 'role_id' => '4', 'email' => 'stockout@gmail.com', 'email_verified_at' =>  $time, 'password' =>$password1, 'created_at' => $time],
            ['name' => 'Only Viewer', 'role_id' => '5', 'email' => 'onlyviewer@gmail.com', 'email_verified_at' =>  $time, 'password' =>$password1, 'created_at' => $time],
            ['name' => 'Knitting', 'role_id' => '7', 'email' => 'knitting@gmail.com', 'email_verified_at' =>  $time, 'password' =>$password1, 'created_at' => $time],
        ];
        DB::table('users')->delete();
        DB::table('users')->insert($users);
    }
}
