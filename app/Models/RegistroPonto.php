<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class RegistroPonto extends Model
{
    use HasFactory;

    protected $table = 'registro_pontos';

    protected $fillable = [
        'user_id',
        'foto',
        'registrado_em',
    ];

    protected $casts = [
        'registrado_em' => 'datetime',
    ];

    /**
     * Relação com o usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Acessor para formatar a data.
     */
    public function getDataFormatadaAttribute()
    {
        return $this->registrado_em
            ? $this->registrado_em->format('d/m/Y H:i:s')
            : null;
    }
}
