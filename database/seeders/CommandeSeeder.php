<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('commandes')->insert([
            [
                "user_id"=>1,
                "totalPrice"=>2
            ]
        ]);
    }
}
