<?php

namespace App\Http\Controllers;

use App\Models\Fichier;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function commande(Request $request,Produit $produit){
       
            // La validation de données
            $request->validate([
                "nom" => ["required", "string", "min:2", "max:255"],
                "adresse"=> ["required", "string", "max:255"],
                "telephone"=> ["required", "string", "max:30"]
              ]);
            //  $produit=Produit::find($id);
              //$produit_id=$produit->id;
              
              $commande =new Commande;
              $commande->nom = $request->nom;
              $commande->adresse = $request->adresse;
              $commande->telephone = $request->telephone;
            $commande->code=  $produit->code; 
            $commande->produit_id=$produit->id; 
              $commande->save();
              return response()->json([
                'commande' => $commande,
            ], 201);}
          
    
}
