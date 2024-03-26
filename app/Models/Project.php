<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'string',
        'end_date' => 'string',
    ];

    protected $guarded = [];

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    public function workFlows(): HasMany
    {
        return $this->hasMany(WorkFlow::class);
    }

    public function issueTypes(): HasMany
    {
        return $this->hasMany(IssueType::class);
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }
}
