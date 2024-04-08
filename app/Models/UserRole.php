<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Common\Enums\Role as RoleEnum;
use App\Models\Role;

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

    // Scopes
    /**
     * @param $query
     * @param int $projectId
     * @return int
     */
    public function scopeCountManagerRoleInProject($query, int $projectId): int
    {
        return $this->whereHas('role', function ($query) use ($projectId) {
            $query->where('project_id', $projectId)
                ->where('name', RoleEnum::MANAGER);
        })->count();
    }
}
