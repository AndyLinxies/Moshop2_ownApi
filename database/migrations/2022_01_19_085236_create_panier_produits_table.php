<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanierProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panier_produit', function (Blueprint $table) {
    
            $table->id();
            //Le panier est créé quand le User est créé MAIS on le met à null afin de "vider " les items du Panier pour passer la commande
            $table->foreignId('panier_id')->nullable()->constrained();
            $table->foreignId('produit_id')->constrained();

            //Commande n'est pas créé à la creation du compte donc au début il est null et ce n'est qu'à la validation du panier qu'il prend une valeur
            $table->foreignId('commande_id')->nullable()->constrained();
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panier_produits');
    }
}
