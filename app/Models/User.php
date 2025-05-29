<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
        'role',
        'image',
        'description',
        'linkedin_url',
        'twitter_url',
        'category'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get user's full name
     */
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->lastname}";
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    /**
     * Check if user is a coach
     */
    public function isCoach()
    {
        return $this->role === 'Coach';
    }

    /**
     * Get all courses created by this user
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get user's profile image URL
     */
    public function getProfileImageAttribute()
    {
        return $this->image ? asset($this->image) : asset('home/assets/img/team/team-6.jpg');
    }

    // Add this relationship method to your User model
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteCourses()
    {
        return $this->belongsToMany(Course::class, 'favorites', 'user_id', 'course_id');
    }

    public function purchasedCourses()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id')->withTimestamps();
    }

    public function chapters()
    {
        return $this->belongsToMany(Chapter::class)->withPivot('quiz_passed')->withTimestamps();
    }
    
public function contracts()
{
    return $this->hasMany(Contract::class);
}
}
