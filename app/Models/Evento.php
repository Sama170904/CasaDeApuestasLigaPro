<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Apuesta;
use App\Models\Equipo; // ✅ IMPORTANTE

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipo_local',
        'equipo_visitante',
        'fecha',
        'estado',
        'resultado',
        'creado_por',
    ];

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function apuestas()
    {
        return $this->hasMany(Apuesta::class);
    }

    public function equipo_local()
    {
        return $this->belongsTo(Equipo::class, 'equipo_local_id');
    }

    public function equipo_visitante()
    {
        return $this->belongsTo(Equipo::class, 'equipo_visitante_id');
    }
}
