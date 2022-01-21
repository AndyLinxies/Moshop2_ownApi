<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            [
                "firstName"=> "Abalo",
                "lastName"=> "Bineta",
                "email"=>"user@user.be",
                'password'=> Hash::make('user@user.be'),
                "picture"=>"default.jpg"
            ]
        ]);
    }
}
