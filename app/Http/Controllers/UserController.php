<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Panier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
        ]);
        //L'image
        $request->file('picture')->storePublicly('img/','public');
        //
        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'picture'=>$request->file('picture')->hashName(),
            'password' => Hash::make($request->password),
        ]);

        //Le Token Il sera stocké dans la DB
        $token=$user->createToken('myToken')->plainTextToken;

        //Le magasin
        $createMagasin= new Magasin;
        $createMagasin->nomMagasin='Le magasin de '.$user->firstName;
        $createMagasin->user_id=$user->id;
        $createMagasin->save();
        //Le panier
        $createPanier= new Panier;
        $createPanier->user_id=$user->id;
        $createPanier->save();

        $response= [
            'message'=>'Utilisateur créé avec succès',
            'user' => $user,
            'token' => $token
        ];

        return response($response,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        //Fonctionne même si c'est en Rouge
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Deconnecté',
        ],201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', Rules\Password::defaults()],
        ]);
        

        //Verification du email. Va chercher le user dont le email est égal au email écrit dans le input
        $user= User::where('email', $request->email)->first();

    
        //Verification du Password
        
        if (!$user || Hash::check($request->password, $user->password)) { //Pour le hash check on verifie le input password (1er param) avec le password du user qu'on a dans notre DB (2e param)
            //Si le email ou le password n'est pas bon:
            return response([
                'message' => "Le email ou le Password n'est pas correct"
            ],401 );//401=Unauthorized
        } else {
            // Si les deux sont bons
             //Le Token. Il sera stocké dans la DB
        $token=$user->createToken('myToken')->plainTextToken;

        $response= [
            'message'=>'Vous vous êtes connecté avec succès',
            'user' => $user,
            'token' => $token,
            'status'=>201
        ];

        return response($response,201);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            
        ]);

        
        $update= User::find($id);
        $update->firstName = $request->firstName;
        $update->lastName = $request->lastName;
        $update->email = $request->email;
        // $update->password = $request->password;

        //Ajouter
        $request->file('picture')->storePublicly('img/','public');
        //modifier
        $update->picture= $request->file('picture')->hashName();

        $update->save();

        $response= [
            'message'=> 'Utilisateur modifié avec succès',
            'user' => $update,
        ];

        return response($response,201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
