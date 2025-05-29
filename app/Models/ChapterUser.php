<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ChapterUser extends Pivot
{
    protected $table = 'chapter_user';

    protected $fillable = [
        'user_id',
        'chapter_id',
        'quiz_passed',
    ];
    public function users()
{
    return $this->belongsToMany(User::class)
        ->using(\App\Models\ChapterUser::class)
        ->withPivot('quiz_passed')
        ->withTimestamps();
}
public function chapters()
{
    return $this->belongsToMany(Chapter::class)
        ->using(\App\Models\ChapterUser::class)
        ->withPivot('quiz_passed')
        ->withTimestamps();
}

}
