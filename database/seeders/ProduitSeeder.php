<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produits')->insert([
            [
                "nomProduit"=>"Ships",
                "descriptionProduit"=>"Ships au gout de paprika",
                "imageProduit"=>"Ships.jpg",
                "prixProduit"=>2,
                "magasin_id"=>1,
                
            ],
            [
                "nomProduit"=>"Bonbon",
                "descriptionProduit"=>"Bonbon au gout de sucre",
                "imageProduit"=>"bonbon.jpg",
                "prixProduit"=>4,
                "magasin_id"=>1,
            ],
            [
                "nomProduit"=>"Chocolat",
                "descriptionProduit"=>"Chocolat noir 99%",
                "imageProduit"=>"chocolat.jpg",
                "prixProduit"=>3,
                "magasin_id"=>1,
            ],
        ]);
    }
}
