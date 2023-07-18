<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fichier extends Model
{
    use HasFactory;
      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image1',
        'image2',
        'image3',
        'image4',
        'image5',
        'produit_id'
    ];
    
    public function produit () {
        return $this->belongsTo(Produit::class);
}
}