<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'subject',
        'status',
        'priority',
        'deadline',
    ];

    // Status
    const PENDING = 0;
    const DONE    = 1;

    // Priority
    const LOW    = 0;
    const MEDIUM = 1;
    const HIGH   = 2;

    const PRIORITY_LABELS = [
        self::LOW    => 'Low',
        self::MEDIUM => 'Medium',
        self::HIGH   => 'High',
    ];

    protected $casts = [
        'deadline' => 'date',
        'status'   => 'integer',
        'priority' => 'integer',
    ];

    public function isDone(): bool
    {
        return $this->status === self::DONE;
    }

    public function isPending(): bool
    {
        return $this->status === self::PENDING;
    }

    public function priorityLabel(): string
    {
        return self::PRIORITY_LABELS[$this->priority] ?? 'Unknown';
    }

    public function priorityClass(): string
    {
        return match($this->priority) {
            self::HIGH   => 'priority-high',
            self::MEDIUM => 'priority-medium',
            default      => 'priority-low',
        };
    }
}
