<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\FichierProduitController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//les routes d'api pour la table utilisateur



//register new user
Route::post("users/inscription", [UserController::class,"inscription"]);
//login user
Route::post("users/connexion", [UserController::class,"connexion"]);
//using middleware
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post("users/logout", [UserController::class,"logout"]);
    Route::get("users", [UserController::class,"index"]);
    Route::get("users/{user}", [UserController::class,"show"]);
    Route::put("users/{user}", [UserController::class,"update"]);
    Route::delete("users/{user}", [UserController::class, "destroy"]);
//lesAPIpour gérer les menus
    Route::post("produits", [ProduitController::class,"store"]);
    Route::get("produits/{produit}", [ProduitController::class,"show"]);
    Route::put("produits/{id}", [ProduitController::class,"update"]);
    Route::delete("produits/{produit}", [ProduitController::class, "destroy"]);
    Route::post("produits/{id}", [ProduitController::class,"reject_post"]);
//lesAPIpour gérer les fichirs des menus
Route::post("fichiers/{produit_id}", [FichierProduitController::class,"store"]);

});
Route::get("fichiers", [FichierProduitController::class,"index"]);
Route::get("produits", [ProduitController::class,"index"]);

Route::post("commandes/{produit}", [CommandeController::class,"commande"]);




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
