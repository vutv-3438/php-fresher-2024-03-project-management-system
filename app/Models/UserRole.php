<?php

namespace App\Models;

use App\Common\Enums\Role as RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRole extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function scopeCountManagerRoleInProject($query, int $projectId): int
    {
        return $query->whereHas('role', function ($query) use ($projectId) {
            $query->where('project_id', $projectId)
                ->where('name', RoleEnum::MANAGER);
        })->count();
    }
}
