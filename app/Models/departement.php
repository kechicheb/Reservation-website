<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departement extends Model
{
    protected $table = 'departements';
    protected $fillable = [

         'nom_dp'
    ];
    // protected $primaryKey = 'code_dp';
    // protected $keyType = 'string';
    // public $incrementing = false;

    use HasFactory;

    public function user_dp()
    {

        return $this ->hasOne(User::class);
    }
}