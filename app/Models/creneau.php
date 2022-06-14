<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class creneau extends Model
{
    protected $table = 'creneaus';
    protected $fillable = ['start','end'];
    //  protected $primaryKey = 'code_cr';

     // protected $keyType = 'string';
    // public $incrementing = false;

    use HasFactory;
}