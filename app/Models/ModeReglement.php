<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeReglement extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
}
