<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Request extends Model
{
    use HasFactory;

    /**
     * Constantes para los estados de la solicitud.
     */
    public const STATUS_REVISION = 'revision';
    public const STATUS_ACEPTADO = 'aceptado';
    public const STATUS_RECHAZADO = 'rechazado';

    /**
     * Lista de estados válidos.
     */
    public const STATUSES = [
        self::STATUS_REVISION,
        self::STATUS_ACEPTADO,
        self::STATUS_RECHAZADO,
    ];

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nombre',
        'email',
        'empresa',
        'tipo_servicio',
        'descripcion_proyecto',
        'status',
        'admin_message',
        'accepted_at',
    ];

    /**
     * Los atributos que deben ser casteados.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'accepted_at' => 'datetime',
    ];

    /**
     * Relación: La solicitud pertenece a un usuario.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Verifica si la solicitud está en revisión.
     *
     * @return bool
     */
    public function isEnRevision(): bool
    {
        return $this->status === self::STATUS_REVISION;
    }

    /**
     * Verifica si la solicitud fue aceptada.
     *
     * @return bool
     */
    public function isAceptada(): bool
    {
        return $this->status === self::STATUS_ACEPTADO;
    }

    /**
     * Verifica si la solicitud fue rechazada.
     *
     * @return bool
     */
    public function isRechazada(): bool
    {
        return $this->status === self::STATUS_RECHAZADO;
    }

    /**
     * Obtiene el badge de estado formateado para la vista.
     *
     * @return array{class: string, label: string}
     */
    public function getStatusBadge(): array
    {
        return match ($this->status) {
            self::STATUS_REVISION => ['class' => 'bg-warning text-dark', 'label' => 'En revisión'],
            self::STATUS_ACEPTADO => ['class' => 'bg-success', 'label' => 'Aceptada'],
            self::STATUS_RECHAZADO => ['class' => 'bg-danger', 'label' => 'Rechazada'],
            default => ['class' => 'bg-secondary', 'label' => 'Desconocido'],
        };
    }
}
