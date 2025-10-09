<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
    public const STATUS_EXPIRED = 'expired';

    public function sedeStand(): BelongsTo {
        return $this->belongsTo(SedeStand::class);
    }

    public static function isAvailable(int $sedeStandId, $date): bool
    {
        return !self::where('sede_stand_id', $sedeStandId)
                ->where('reservation_date', $date)
                ->whereIn('status', [self::STATUS_PENDING, self::STATUS_PAID])
                ->exists();
    }

    public static function findByKeyCode(string $keyCode): ?self
    {
        return self::where('key_code', strtoupper($keyCode))->first();
    }

    public static function generateKeyCode(): string 
    {
        do {
            $characters = 'BCDFGHJKLMNPQRSTVWXYZ23456789';
            $code = '';

            for ($i=0; $i < 8; $i++) { 
                $code .= $characters[rand(0, strlen($characters) - 1)];
            }

            $keyCode = substr($code, 0, 4) . '-' . substr($code, 4, 4) . '-FL';

            $exists = self::where('key_code', $keyCode)->exists();
        } while($exists);

        return $keyCode;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reservation) {
            if (empty($reservation->key_code)) {
                $reservation->key_code = self::generateKeyCode();
            }
        });
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => self::getStatusLabels()[$this->status] ?? 'Desconocido'
        );
    }

    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_PAID => 'Pagado',
            self::STATUS_CANCELED => 'Cancelado',
            self::STATUS_EXPIRED => 'Expirado'
        ];
    }

    public static function selectableStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_PAID => 'Pagado',
            self::STATUS_CANCELED => 'Cancelado',
        ];
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function isCanceled(): bool
    {
        return $this->status === self::STATUS_CANCELED;
    }

    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED;
    }

    /**
     * Scope para reservas activas (que bloquean disponibilidad)
    */
    public function scopeActive($query)
    {
        return $query->whereIn('status', [
            self::STATUS_PENDING,
            self::STATUS_PAID
        ]);
    }

    /**
     * Scope para verificar disponibilidad de un stand en una fecha
    */
    public function scopeForStandAndDate($query, int $sedeStandId, string $date) {
        return $query->where('sede_stand_id', $sedeStandId)->where('reservation_date', $date);
    }
}
