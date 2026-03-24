<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role_id'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ── Relationships ──

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withTimestamps();
    }

    public function createdProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    public function reportedBugs(): HasMany
    {
        return $this->hasMany(Bug::class, 'reporter_id');
    }

    public function assignedBugs(): HasMany
    {
        return $this->hasMany(Bug::class, 'assigned_to');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    // ── Role Helpers ──

    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }

    public function isDeveloper(): bool
    {
        return $this->role?->name === 'developer';
    }

    public function isTester(): bool
    {
        return $this->role?->name === 'tester';
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role?->name, $roles);
    }
}
