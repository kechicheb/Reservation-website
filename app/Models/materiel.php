<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materiel extends Model
{
    protected $table = "materiels";
    protected $fillable = [
        'n_serie',
        'nom',
        'marque',
        'desecription',

    ];
    use HasFactory;
}