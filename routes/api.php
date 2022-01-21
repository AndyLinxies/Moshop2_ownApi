<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Routes publiques
Route::get('/', function () {
    $produits=DB::table('produits')->where('magasin_id','=',1)->get();;
    return response()->json([
        'message' =>'Produits par défaut',
        'data' => $produits
    ],
200);
});

//Le login est public
Route::post('/dashboard/login',[UserController::class,'login']);

//Register new User est public
Route::post('/register',[UserController::class,'store']);

//Routes Protégés
Route::group(['middleware' => ['auth:sanctum']], function (){
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');
    
    Route::get('/dashboard/profile', function () {
        $profile=Auth::user();
        return response()->json([
            'message' =>'Informations sur le User',
            'data' => $profile
        ],
    201);
    });

    //USER
    //logout
    Route::post('/dashboard/logout',[UserController::class,'logout']);

    //Modifier les infos
    Route::put('/dashboard/profile/{id}/update',[UserController::class,'update']);
    
    Route::get('/dashboard/personal-shop', function () {
        //Passe par le model
        $user=Auth::user()->mag->id;
        $personalShop=DB::table('produits')->where('magasin_id','=',$user)->get();
        // dd($personalShop);
        return response()->json([
            'message' =>'Votre Shop personel',
            'data' => $personalShop
        ],201);
    });
    
    Route::get('/dashboard/panier', function () {
        //Panier du user connecté
        //->cart est possible car le user est directement relié au panier
        //Panier détient la foreing key de User donc user hasOne panier
        $userPanier=Auth::user()->cart->id;
    
        //on part de la table intermédiaire
        $productOfpanier=DB::table('panier_produit')
        ->leftJoin('produits','panier_produit.produit_id','=','produits.id')
        ->where('panier_id','=',$userPanier)->get()
        ;
        
        // dd($productOfpanier);
        return response()->json([
            'message' =>'Votre Panier',
            'data' => $productOfpanier
        ],201);;
    });
    
    Route::get('/dashboard/commandes', function () {
        $user=Auth::user()->id;
        $commandes=DB::table('commandes')
        ->where('user_id','=',$user)->get()
        ;

        return response()->json([
            'message' =>'Vos Commandes',
            'data' => $commandes
        ],201);
    });
    
    Route::get('/dashboard/allShops', function () {
        $magasins=DB::table('magasins')->leftJoin('users','magasins.user_id','=','users.id')->get();
        return response()->json([
            'message' =>'Tous les magasins',
            'data' => $magasins
        ],201);    
    });
    
    //Ajouter un Produit
    Route::post('/dashboard/produit/create',[ProduitController::class,'store']);
    //Supprimer un produit
    Route::delete("/dashboard/produit/{id}/delete",[ProduitController::class,'destroy']);
    //Modifier un produit
    Route::put("/dashboard/produit/update/{id}",[ProduitController::class,'update']);
    
    
    //Ajouter au panier 
    //Je passe le id dans les params de la route pour pouvoir retrouver le Produit surlequel on a cliqué via un find id dans le store
    Route::post('/dashboard/ajoutPanier/produit/{id}',[PanierController::class,'store']);
    
    
    
    //Ajout d'une commande
    Route::post('/dashboard/ajoutCommande',[CommandeController::class,'store']);
    
    //Commande detail
    Route::get('/dashboard/commandeDetail/{id}', function ($id) {
            //On peut mettre les where en fonction des donnés récupérés grace aux joins. Pas seulement en fonction de la table du début.
            $produits=DB::table('panier_produit')
            ->join('produits','panier_produit.produit_id','=','produits.id')
            ->join('commandes','panier_produit.commande_id','=','commandes.id')
            ->where('panier_id',null)
            ->where('user_id',Auth::id())
            ->where('commande_id',$id)
            ->get();
            return response()->json([
                'message' =>'Les détails de la Commandes',
                'data' => $produits
            ],201);    });
    
    //All shops Details
    Route::get('/dashboard/allShopsDetail/{id}', function ($id) {
        $produits=DB::table('produits')
        ->where('magasin_id',$id)
        ->get()
        ;
    
        $conectedUser=Auth::id();
        return response()->json([
            'message' =>'Les articles des autres shops',
            'data' => $produits,
            'connectedUser'=>Auth::id()
        ],201);    
    });
});