<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MagasinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('magasins')->insert([
            [
                "nomMagasin"=>"Magasin par Defaut",
                "user_id"=>1,
            ],
        ]);
    }
}
