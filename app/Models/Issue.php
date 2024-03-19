<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Issue extends Model
{
    use HasFactory;

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function workFlowStep(): BelongsTo
    {
        return $this->belongsTo(WorkFlowStep::class);
    }

    public function parentIssue(): HasOne
    {
        return $this->hasOne(self::class, 'id', 'parent_issue_id');
    }

    public function assignee(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'assignee_id');
    }

    public function reporter(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'reporter_id');
    }

    public function childIssues(): HasMany
    {
        return $this->hasMany(self::class, 'parent_issue_id', 'id');
    }

    public function logTimes(): HasMany
    {
        return $this->hasMany(LogTime::class);
    }
}
