<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sede extends Model
{
    //
    protected $fillable = [
        'title', 
        'short_title', 
        'address', 
        'image', 
        'capacity', 
        'is_active'
    ];
    protected $casts = ['is_active' => 'boolean'];
    
    public function sedeStands():HasMany {
        return $this->hasMany(SedeStand::class);
    }

    //public function stands() {
    //    return $this->hasManyThrough(Stand::class, SedeStand::class, 'sede_id', 'id', 'id', 'stand_id');
    //}

    // Acceso directo a stands mediante la tabla pivote
    public function stands()
    {
        return $this->belongsToMany(Stand::class, 'sede_stands')
                    ->withPivot(['price', 'is_active'])
                    ->withTimestamps();
    }
}
