<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function famille()
    {
        return $this->belongsTo(Famille::class);
    }
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }
    public function modeReglement()
    {
        return $this->belongsTo(ModeReglement::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unite()
    {
        return $this->belongsTo(Unite::class);
    }
   
}
