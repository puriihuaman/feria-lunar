<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SedeStand extends Model
{
    //
    use HasFactory;

    protected $table = 'sede_stands';

    protected $fillable = [
        'sede_id', 
        'stand_id', 
        'price', 
        'is_active'
    ];
    protected $casts = ['is_active' => 'boolean', 'price' => 'decimal:2'];

    public function sede(): BelongsTo {
        return $this->belongsTo(Sede::class); 
    }

    public function stand(): BelongsTo {
        return $this->belongsTo(Stand::class);
    }
    
    public function reservas(): HasMany {
        return $this->hasMany(Reserva::class, 'sede_stand_id');
    }

    public function statusToDate(string $date): string
    {
        $reserva = $this->reservas()
            ->where('reservation_date', $date)
            ->whereIn('status', [\App\Models\Reserva::STATUS_PENDING, \App\Models\Reserva::STATUS_PAID])
            ->first();

        if (!$reserva) {
            return 'free';
        }

        return $reserva->status;
    }
}
