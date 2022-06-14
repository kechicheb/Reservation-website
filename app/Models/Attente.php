<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attente extends Model
{
    protected $table = "attentes";
    protected $fillable = ['matricule','code_salle','code_creneau','date_reservation'];
    use HasFactory;
}