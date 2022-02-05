<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;
use Illuminate\support\Facades\Hash;


class add_first_user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Test",
            'email' => "testmail@123",
            "employee_id"=> 1,
            'password' => Hash::make('test@123'),
        ]);
        DB::table('user_addresses')->insert([
            "user_id"=> 1,
            "city"=> "rddrdr",
            "country"=> "india",
            "pincode"=> 676767,
            "state"=> "kerala",
            "street_name"=> "test street",
            "building_no"=> "building",
        ]);
    }
}
