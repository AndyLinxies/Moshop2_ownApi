<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePanierRequest;
use App\Http\Requests\UpdatePanierRequest;
use App\Models\Panier;
use App\Models\panier_produit;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
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
     * @param  \App\Http\Requests\StorePanierRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id,StorePanierRequest $request)
    {
         //Mettre messages de validation
         $request->validate([
            'quantity' => ['required']
        ]);

        //Pour le Panier il est deja lié et crée quand l'utilisateur a créé son compte 
        //Pour la table pivot
        $store= new panier_produit;
        $store->panier_id=Auth::user()->cart->id;
        $produit=Produit::find($id);
        // dd($produit->id);
        $store->produit_id= $produit->id;
        $store->quantity=$request->quantity;
        $store->save();

        return response()->json([
            'message' =>'Produit(s) ajouté(s) au Panier avec succès',
            'data' => $store
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function show(Panier $panier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function edit(Panier $panier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePanierRequest  $request
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePanierRequest $request, Panier $panier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Panier $panier)
    {
        //
    }
}
