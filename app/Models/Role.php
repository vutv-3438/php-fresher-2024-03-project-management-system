<?php

namespace App\Models;

use App\Common\Enums\Role as RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'is_manager',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, UserRole::class);
    }

    public function userRoles(): HasMany
    {
        return $this->hasMany(UserRole::class);
    }

    public function roleClaims(): HasMany
    {
        return $this->hasMany(RoleClaim::class);
    }

    // Scopes
    public function scopeIsManager(): bool
    {
        return $this->name === RoleEnum::MANAGER;
    }

    // Attributes
    public function getIsManagerAttribute()
    {
        return $this->isManager();
    }
}
