<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommandeRequest;
use App\Http\Requests\UpdateCommandeRequest;
use App\Models\Commande;
use App\Models\panier_produit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommandeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommandeRequest $request)
    {
        $productOfpanier=DB::table('panier_produit')
    ->leftJoin('produits','panier_produit.produit_id','=','produits.id')
    ->where('panier_id','=',Auth::user()->cart->id)->get()
    ;
    // dd($productOfpanier);

    //Somme des prix contenus dans le json
    $sommePrix= $productOfpanier->sum('prixProduit');

        $store=new Commande;
        $store->user_id=Auth::user()->id;
        $store->date=Carbon::now();
        $store->totalPrice=$sommePrix;
        $store->save();

        
        $product=DB::table('panier_produit')
        ->where('panier_id','=',Auth::user()->cart->id)->get()
    ;
    //Methode 1 Pour la modification
        // Dans panier_produit Rajouter la commande_id et mettre le panier_id à null
        foreach ($product as $userCartDetail) {
            $storePivot=panier_produit::find($userCartDetail->id);
            $storePivot->commande_id=$store->id;
            $storePivot->panier_id=null;
            $storePivot->save();
        }

        
        //Methode 2 Pour la modification
        // foreach ($product as $prodPan) {
        //     Panier_produit::where('commande_id',$prodPan->commande_id )->update(array('panier_id' => null));
        // }

        

        return response()->json([
            'message' =>'Commande créée avec succès',
            'data' => $store
        ],201);    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommandeRequest  $request
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommandeRequest $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        //
    }
}
