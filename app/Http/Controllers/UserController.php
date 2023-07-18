<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function inscription(Request $request){
        $utilisateurDonnee = $request->validate([
            "name" => ["required", "string", "min:2", "max:255"],
            "email"=> ["required", "email", "unique:users,email"],
            "password"=> ["required", "string", "min:8", "max:30","confirmed"]
        ]);
        $user = User::create([
           "name" => $utilisateurDonnee["name"],
           "email" => $utilisateurDonnee["email"], 
           "password" => bcrypt($utilisateurDonnee["password"]) 
 
        ]);
        $token =$user->createToken("CLE_SECRET")->plainTextToken;
        return  response([
         "user" => $user,
         "token" => $token
        ], 201);
    }
    public function connexion(Request $request){
        $utilisateurDonnee = $request->validate([
            
            "email"=> ["required", "email"],
            "password"=> ["required", "string", "min:8", "max:30"]
        ]);

        $user= User::where("email", $utilisateurDonnee["email"])->first();
       if(!$user) return response(["message" => "Aucun utilisateur trouver avec l'email suivant $utilisateurDonnee[email]"],401);
       if(!Hash::check($utilisateurDonnee["password"], $user->password)) {
        return response(["message" => "Aucun utilisateur trouver avec ce password "],401); 
       } 
       //$usertype=User::where("usertype","=","admin");
       if($user->usertype == "admin"){
        $message="bonjour admin";
       }else{
        $message="bonjour user";
       }
        $token = $user->createToken("CLE_SECRET")->plainTextToken;
        return  response([
         "user" => $user,
         "token" => $token,
         "message"=> $message
        ], 200);
    }
    public function logout(Request $request)
{
   auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
}
    public function index()
    {
    //     // On récupère tous les utilisateurs
    
     $users = User::all();

    // // On retourne les informations des utilisateurs en JSON
     return response()->json($users);
    }
    public function show(User $user)
{
    // On retourne les informations de l'utilisateur en JSON
    return response()->json($user);
}
    public function update(Request $request, User $user)
    {
        // La validation de données
        $utilisateurDonnee = $request->validate([
            "name" => ["required", "string", "min:2", "max:255"],
            "email"=> ["required", "email"],
            "password"=> ["required", "string", "min:8", "max:30"]
        ]);


    // On modifie les informations de l'utilisateur
    $user->update([
        "name" => $utilisateurDonnee["name"],
        "email" => $utilisateurDonnee["email"], 
        "password" => bcrypt($utilisateurDonnee["password"]) 

     ]);
       // On retourne la réponse JSON
       return response()->json($user);
    }
    public function destroy(User $user)
    {
         // On supprime l'utilisateur
        $user->delete();

        // On retourne la réponse JSON
        return response()->json();
    }   
    
}
