<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class enseignant extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'enseignants';

    protected $fillable = [
        'matricule',
        'nom_prenom',
        'email',
        'password',
        'telephone',
        'type_etat',
        'type_status',
        'code_dp',
    ];

    protected $primaryKey = 'matricule';
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
         // 'password'=> 'encrypted'
    ];


    public function typestatus()
    {
        return $this->belongsTo(Statu::class, 'type_status');
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'code_dp');
    }


    public function reservations() {

        return $this->hasMany(reservation::class,'matricule','matricule');
    }
}