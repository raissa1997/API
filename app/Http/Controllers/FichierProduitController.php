<?php

namespace App\Http\Controllers;

use App\Models\Fichier;
use App\Models\Produit;
use Illuminate\Http\Request;

class FichierProduitController extends Controller
{
    public function index(){

        $fichierproduits = Fichier::All();
        return response()->json($fichierproduits);   
    }
    public function store(Request $request,$id){
        // La validation de données
        $request->validate([
            'image1'=>'image|mimes:jpeg,png,jpg,svg|max:2048',
            'image2'=>'image|mimes:jpeg,png,jpg,svg|max:2048',
            'image3'=>'image|mimes:jpeg,png,jpg,svg|max:2048',
            'image4'=>'image|mimes:jpeg,png,jpg,svg|max:2048',
            'image5'=>'image|mimes:jpeg,png,jpg,svg|max:2048'
            ]);
            $produit=Produit::find($id);

            $produit_id=$produit->id;
        $fichierproduit = new Fichier;
        $file_name1 = time() .'.'. request()->image1->getClientOriginalExtension();
        request()->image1->move(public_path('images'), $file_name1);
        $file_name2 = time() .'.'. request()->image2->getClientOriginalExtension();
        request()->image2->move(public_path('images'), $file_name2);
        $file_name3 = time() .'.'. request()->image3->getClientOriginalExtension();
        request()->image3->move(public_path('images'), $file_name3);
        $file_name4 = time() .'.'. request()->image4->getClientOriginalExtension();
        request()->image4->move(public_path('images'), $file_name4);
        $file_name5 = time() .'.'. request()->image5->getClientOriginalExtension();
        request()->image5->move(public_path('images'), $file_name5);
        $fichierproduit->image1 = $file_name1;
        $fichierproduit->image2 = $file_name2;
        $fichierproduit->image3 = $file_name3;
        $fichierproduit->image4 = $file_name4;
        $fichierproduit->image5 = $file_name5;
        $fichierproduit->produit_id=$produit_id; 
        $fichierproduit->save();
        return response()->json($fichierproduit, 201);
    }
}
