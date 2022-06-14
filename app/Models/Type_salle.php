<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Type_salle extends Model
{
    protected $table = 'type_salles';
    protected $fillable = [
         'type_salle'
    ];
    // protected $primaryKey = 'type_salle';
    // protected $keyType = 'string';
    // public $incrementing = false;


    use HasFactory;
    public function salles()
{

    return $this ->hasOne(Salle::class);
}

}