<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillEcosystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'ecosystem', 'icon', 'proficiency', 'order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'proficiency' => 'integer',
        'order' => 'integer'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByEcosystem($query, $ecosystem)
    {
        return $query->where('ecosystem', $ecosystem);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }
}