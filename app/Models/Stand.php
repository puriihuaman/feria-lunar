<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stand extends Model
{
    //
    protected $fillable = [
        'booth_number', 
        'category', 
        'description', 
        'is_active'
    ];
    protected $casts = ['is_active' => 'boolean'];

    public function sedeStands(): HasMany {
        return $this->hasMany(SedeStand::class);
    }

    // Relación muchos a muchos con sedes
    public function sedes()
    {
        return $this->belongsToMany(Sede::class, 'sede_stands')
                    ->withPivot(['price', 'is_active'])
                    ->withTimestamps();
    }
}
