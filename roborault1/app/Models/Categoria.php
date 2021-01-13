<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Creation of the relation between the Category models and Project
    public function projeto(){
        return $this->hasMany(Projeto::class);
    }
}
