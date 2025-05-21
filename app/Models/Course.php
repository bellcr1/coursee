<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'category',
        'name_cotcher',
        'description',
        'price',
        'duration',
        'image',
        'video',
        'user_id',
        'chapter'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function isFavorited()
    {
        if (!auth()->check()) {
            return false;
        }
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }

    public function toggleFavorite()
    {
        if (!auth()->check()) {
            return false;
        }

        $favorite = $this->favorites()->where('user_id', auth()->id())->first();

        if ($favorite) {
            $favorite->delete();
            return false;
        }

        $this->favorites()->create([
            'user_id' => auth()->id()
        ]);
        return true;
    }

    public function purchasers()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id')->withTimestamps();
    }
}
