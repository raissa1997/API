<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index(){

        $produits=Produit::All()->where('produit_status','=','active');
        return response()->json($produits);   
    }
    public function store(Request $request){
        // La validation de données
        $request->validate([
            "title" => ["required", "string", "min:2", "max:255"],
            "description"=> ["required", "string", "max:255"],
            "price"=> ["required", "string", "max:30"],
            'image'=>'image|mimes:jpeg,png,jpg,svg|max:2048'
            ]);
            $user=Auth()->user();
            $user_id=$user->id;
        $produit = new Produit;
        $prefix = 'PR'; // Remplacez 'PR' par les 2 lettres précises de votre choix
        $suffix = Str::random(6); // Génère une chaîne aléatoire de 6 caractères
        $produit->code = $prefix . $suffix;
       // $produit->code = Str::random(8); // Générez un code aléatoire de 8caractères
        $file_name = time() .'.'. request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $file_name);
        $produit->title = $request->title;
        $produit->description = $request->description;
        $produit->price = $request->price;
        $produit->user_id=$user_id; 
        $produit->image = $file_name;
        $produit->save();
        return response()->json($produit, 201);
    }
    public function show(Produit $produit){

        return response()->json($produit);

    }
    public function update(Request $request,Produit $produit, $id)
    {
       // Récupérez les données du formulaire
         // La validation de données
         $this->validate($request, [
            "title" => ["string", "min:2", "max:255"],
            "description"=> ["string", "max:255"],
            "price"=> ["string", "max:30"],
            'image'=>'image|mimes:jpeg,png,jpg,svg|max:2048'  
        ]);
       $description = $request->input('description');
       $title = $request->input('title');
       $price = $request->input('price');

       $user=Auth()->user();
        $user_id=$user->id;
   // Vérifiez si le produit existe
   $produit = Produit::find($id);

   $prefix = 'PR'; // Remplacez 'PR' par les 2 lettres précises de votre choix
   $suffix = Str::random(6); // Génère une chaîne aléatoire de 6 caractères
   $produit->code = $prefix . $suffix;

   // Mettez à jour les champs nécessaires
   $produit->user_id=$user_id; 
   $produit->description = $description;
   $produit->title = $title;
   $produit->price = $price;


   // Vérifiez si une image est présente dans la requête et la sauvegarder si besoin
   if ($request->hasFile('image')) {
       $image = $request->file('image');
       $imageUrl = $image->store('public/images');
       $produit->image = $imageUrl;
   }

   // Enregistrez les changements sur le produit
   $produit->save();

   return response()->json(['message' => 'Produit mis à jour avec succès', 'produit' => $produit], 200);
    }
    public function destroy(Produit $produit)
    {
         // On supprime l'utilisateur
        $produit->delete();

        // On retourne la réponse JSON
        return response()->json();
    }
    public function reject_post(Produit $produit,$id){   
        $produit=Produit::find($id);
        $produit->produit_status= 'rejected';
        $produit->save();
    return response()->json(['message' => 'Produit bloqué avec succès'], 200);
}
    
}
