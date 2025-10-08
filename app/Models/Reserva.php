<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reserva extends Model
{
    //
    protected $fillable = [
        'sede_stand_id', 
        'reservation_date', 
        'price', 
        'status', 
        'name', 
        'surname', 
        'email', 
        'phone', 
        'key_code', 
        'confirmation_date'
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'confirmation_date' => 'datetime',
        'price' => 'decimal:2',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_EXPIRADO = 'expired';

    public function sedeStand(): BelongsTo {
        return $this->belongsTo(SedeStand::class);
    }

    /** Retorna true si hay reserva con estado que bloquea la fecha (pendiente, pagado) */
    public static function isAvailable(int $sedeStandId, $date): bool
    {
        return !self::where('sede_stand_id', $sedeStandId)
                ->where('reservation_date', $date)
                ->whereIn('status', [self::STATUS_PENDING, self::STATUS_PAID])
                ->exists();
    }

}
