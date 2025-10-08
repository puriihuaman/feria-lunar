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

    // ✅ Método para verificar estado
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

    // public static function statuses(): array
    // {
    //     return [
    //         self::STATUS_PENDING => 'Pendiente',
    //         self::STATUS_PAID => 'Pagado',
    //         self::STATUS_CANCELED => 'Cancelado',
    //     ];
    // }
}
