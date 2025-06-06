<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Apuesta;
use App\Models\Equipo;

class Evento extends Model
{
    use HasFactory;

    // ✅ Campos permitidos para asignación masiva
    protected $fillable = [
        'equipo_local_id',
        'equipo_visitante_id',
        'fecha_evento',
        'estado',
        'marcador_local',
        'marcador_visitante',
    ];

    // ✅ Casts para asegurar tipos correctos al guardar en base de datos
    protected $casts = [
        'marcador_local' => 'integer',
        'marcador_visitante' => 'integer',
    ];

    // ✅ Relación con el equipo local
    public function equipo_local()
    {
        return $this->belongsTo(Equipo::class, 'equipo_local_id');
    }

    // ✅ Relación con el equipo visitante
    public function equipo_visitante()
    {
        return $this->belongsTo(Equipo::class, 'equipo_visitante_id');
    }

    // ✅ Relación con apuestas
    public function apuestas()
    {
        return $this->hasMany(Apuesta::class);
    }

    // 🧠 (Opcional) Método para determinar el resultado
    public function resultado()
    {
        if ($this->marcador_local === null || $this->marcador_visitante === null) {
            return null;
        }

        if ($this->marcador_local > $this->marcador_visitante) {
            return 'local';
        } elseif ($this->marcador_local < $this->marcador_visitante) {
            return 'visitante';
        } else {
            return 'empate';
        }
    }
}
