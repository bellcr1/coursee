<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['title', 'chapter_id', 'order', 'start_time'];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}