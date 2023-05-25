<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $role = [
            ['role_id' => 1, 'role_name' => 'Super Admin', 'created_at' => Carbon::now()],
            ['role_id' => 2, 'role_name' => 'Merchandiser Representative ', 'created_at' => Carbon::now()],
            ['role_id' => 3, 'role_name' => 'Store Representative', 'created_at' => Carbon::now()],
            ['role_id' => 4, 'role_name' => 'Stock Out', 'created_at' => Carbon::now()],
            ['role_id' => 5, 'role_name' => 'Only Viewer', 'created_at' => Carbon::now()],
            ['role_id' => 6, 'role_name' => 'Senior Merchandiser', 'created_at' => Carbon::now()],
            ['role_id' => 7, 'role_name' => 'Knitting', 'created_at' => Carbon::now()],
        ];
        DB::table('roles')->delete();
        DB::table('roles')->insert($role);
    }
}
