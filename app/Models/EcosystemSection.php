<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcosystemSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'ecosystem', 'title', 'description', 'is_visible', 'order'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'order' => 'integer'
    ];

    public function skills()
    {
        return $this->hasMany(SkillEcosystem::class, 'ecosystem', 'ecosystem');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}