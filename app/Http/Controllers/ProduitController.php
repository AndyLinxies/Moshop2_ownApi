<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
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
     * @param  \App\Http\Requests\StoreProduitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduitRequest $request)
    {
        $request->validate([
            'nomProduit' => ['required', 'string', 'max:255'],
            'descriptionProduit' => ['required', 'string', 'max:255'],
            'imageProduit' => ['required', 'image'],
            'prixProduit' => ['required'],
        ]);

        $store=new Produit;
        $store->nomProduit=$request->nomProduit;
        $store->descriptionProduit=$request->descriptionProduit;
        $request->file('imageProduit')->storePublicly('img/','public');
        $store->imageProduit=$request->file('imageProduit')->hashName();
        $store->prixProduit=$request->prixProduit;
        $store->magasin_id=Auth::user()->mag->id;

        $store->save();
        return response()->json([
            'message' =>'Produit créé avec succès',
            'data' => $store
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Produit $produit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProduitRequest  $request
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update($id,UpdateProduitRequest $request)
    {
        $request->validate([
            'nomProduit' => ['required', 'string', 'max:255'],
            'descriptionProduit' => ['required', 'string', 'max:255'],
            'imageProduit' => ['required', 'image'],
            'prixProduit' => ['required'],
        ]);

        $update=Produit::find($id);
        $update->nomProduit=$request->nomProduit;
        $update->descriptionProduit=$request->descriptionProduit;
        $request->file('imageProduit')->storePublicly('img/','public');
        $update->imageProduit=$request->file('imageProduit')->hashName();
        $update->prixProduit=$request->prixProduit;
        $update->magasin_id=Auth::user()->mag->id;

        $update->save();
        return response()->json([
            'message' =>'Produit modifié avec succès',
            'data' => $update
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Produit $produit)
    {
        $destroy=Produit::find($id);
        Storage::disk('public')->delete('img'.$destroy->imageProduit);
        $destroy->delete();
        return response()->json([
            'message' =>'Produit supprimé avec succès',
            'data' => $destroy
        ],201);    }
}
