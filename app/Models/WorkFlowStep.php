<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkFlowStep extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function workFlow(): BelongsTo
    {
        return $this->belongsTo(WorkFlow::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class, 'status_id', 'id');
    }

    public function previousStatuses(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'next_steps_allowed',
            'to_status_id',
            'from_status_id'
        );
    }

    public function nextStatusesAllowed(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'next_steps_allowed',
            'from_status_id',
            'to_status_id'
        );
    }
}
