<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Issue extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the value of the date column as a formatted date.
     *
     * @param string|null $value
     * @return string
     */
    public function getDueDateAttribute(?string $value): string
    {
        return $value ? $this->asDateTime($value)->format('d-m-Y') : '---';
    }

    public function getStartDateAttribute($value): string
    {
        return $value ? $this->asDateTime($value)->format('d-m-Y') : '---';
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(WorkFlowStep::class, 'status_id');
    }

    public function issueType(): BelongsTo
    {
        return $this->belongsTo(IssueType::class);
    }

    public function parentIssue(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_issue_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function childIssues(): HasMany
    {
        return $this->hasMany(self::class, 'parent_issue_id');
    }

    public function logTimes(): HasMany
    {
        return $this->hasMany(LogTime::class);
    }
}
