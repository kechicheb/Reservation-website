<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    protected $table = 'salles';
    protected $fillable = [
        'code_salle', 'type_salle', 'capacite','etage','special'
    ];

    protected $primaryKey = 'code_salle';
    protected $keyType = 'string';
    public $incrementing = false;



    public function typesalle()
    {
        return $this->belongsTo(Type_salle::class, 'type_salle');
    }


}