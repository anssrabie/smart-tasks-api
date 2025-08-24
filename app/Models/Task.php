<?php

namespace App\Models;

use App\Constants\CacheKeys;
use App\Constants\TenantCacheKeys;
use App\Traits\AutoFlushCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Task extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, AutoFlushCache;
    protected array $primaryCacheKeys = [CacheKeys::TASK];
    protected array $cacheKeys= [CacheKeys::TASKS_INDEX];

    protected $fillable = ['title','description','status_id','owner_id','assigned_to'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->useLogName('Task')
            ->logOnly(['status_id', 'assigned_to']);
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $userName = auth()->user()?->name ?? 'System';

        if ($eventName === 'updated') {
            $changes = $this->getChanges();

            if (array_key_exists('status_id', $changes)) {
                $oldStatus = optional(Status::find($this->getOriginal('status_id')))->name ?? $this->getOriginal('status_id');
                $newStatus = optional(Status::find($changes['status_id']))->name ?? $changes['status_id'];

                return "{$userName} changed task status from {$oldStatus} to {$newStatus}";
            }

            if (array_key_exists('assigned_to', $changes)) {
                $oldUser = optional(User::find($this->getOriginal('assigned_to')))->name ?? $this->getOriginal('assigned_to');
                $newUser = optional(User::find($changes['assigned_to']))->name ?? $changes['assigned_to'];

                return $oldUser ? "{$userName} reassigned task from {$oldUser} to {$newUser}" : "{$userName} assigned task to {$newUser}";
            }
        }

        return "{$userName} has {$eventName} the task";
    }

    protected static function booted()
    {
        static::creating(function ($task) {
            $task->owner_id = auth()->id();
        });
    }


    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class,'assigned_to');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class,'owner_id');
    }
}
