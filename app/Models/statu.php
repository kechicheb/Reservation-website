<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statu extends Model
{
    protected $table = 'status';
    protected $fillable = [
         'type_status'
    ];
    // protected $primaryKey = 'type_status';
    // protected $keyType = 'string';
    // public $incrementing = false;
    use HasFactory;

    public function user_st()
    {

        return $this ->hasOne(User::class);
    }
}