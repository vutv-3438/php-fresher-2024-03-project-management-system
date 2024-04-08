<?php

namespace App\Models;

use App\Common\Enums\Role as RoleEnum;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    private const IS_ACTIVE = 1;
    private const IS_ADMIN = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'user_name',
        'first_name',
        'last_name',
        'avatar',
        'phone_number',
    ];

    protected $guarded = [
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['full_name', 'is_deleted'];

    public function assignedIssue(): HasOne
    {
        return $this->hasOne(Issue::class, 'assignee_id');
    }

    public function reportedIssue(): BelongsTo
    {
        return $this->belongsTo(Issue::class, 'reporter_id', 'id');
    }

    public function userRoles(): HasMany
    {
        return $this->hasMany(UserRole::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, UserRole::class, 'user_id', 'role_id');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getIsDeletedAttribute(): bool
    {
        return $this->trashed();
    }

    public function setUserNameAttribute($value)
    {
        $this->attributes['user_name'] = Str::slug($value);
    }

    /**
     * Scope a query to only admin users.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('is_admin', self::IS_ADMIN);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('ancient', function (Builder $builder) {
            $builder->where('is_active', self::IS_ACTIVE);
        });
    }

    public function hasRoleInProject(string $roleName, int $projectId): bool
    {
        return $this->roles->contains(function ($role) use ($roleName, $projectId) {
            return $role->name === $roleName && $role->project_id === $projectId;
        });
    }

    public function hasPermissionInProject(int $projectId, string $resource, string $action): bool
    {
        return $this->hasRoleInProject(RoleEnum::MANAGER, $projectId) ||
            $this->roles->contains(function ($role) use ($resource, $action, $projectId) {
                return $role->project_id === $projectId && $role->roleClaims()
                        ->where('claim_type', $resource)
                        ->where('claim_value', $action)
                        ->exists();
            });
    }
}
