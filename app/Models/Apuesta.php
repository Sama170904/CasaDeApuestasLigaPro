<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Evento;

class Apuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'evento_id',
        'tipo_apuesta',
        'prediccion',
        'cantidad',
        'es_correcta',
    ];


    // 🔁 Relación con el usuario que hizo la apuesta
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔁 Relación con el evento al que pertenece la apuesta
    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
