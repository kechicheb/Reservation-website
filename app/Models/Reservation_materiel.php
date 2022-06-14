<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation_materiel extends Model
{
    protected $table = 'reservation_materiels';
    protected $fillable = [
        'code_reservation',
        'code_materiel',

    ];
    use HasFactory;


    public function materiel()
    {
        return $this->belongsTo(Creneau::class, 'code_materiel');
    }


    public function reservation()
    {
        return $this->belongsTo(reservation::class, 'code_reservation');
    }
}
