<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'username',
        'job_title',
        'short_bio',
        'phone_number',
        'location',
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

    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) {
            return null;
        }

        // If it's a full URL (external), return as is
        if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return $this->avatar;
        }

        // Use asset() to ensure the URL matches the current request host (127.0.0.1 vs localhost)
        return asset('storage/' . $this->avatar);
    }

    public function isAdmin()
    {
        return strtolower($this->role) === 'admin';
    }

    public function ownedProjects()
    {
        return $this->hasMany(Project::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('role')->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
