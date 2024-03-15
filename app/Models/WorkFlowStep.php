<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkFlowStep extends Model
{
    use HasFactory;

    public function workFlow(): BelongsTo
    {
        return $this->belongsTo(WorkFlow::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }
}
