<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reservation extends Model
{
    protected $table = "reservations";
    protected $fillable = ['matricule','code_salle','code_creneau','date_reservation','attente'];
    // protected $primaryKey = 'code_reservation';


    public function salle()
    {
        return $this->belongsTo(Salle::class, 'code_salle');
    }



    public function creneau()
    {
        return $this->belongsTo(Creneau::class, 'code_creneau');
    }


    public function enseignant()
    {
        return $this->belongsTo(enseignant::class, 'matricule');
    }
    // public function reserv_materiel()
    // {
    //     return $this->belongsTo(Reservation_materiel::class);
    // }




    use HasFactory;
}