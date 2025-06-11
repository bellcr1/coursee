<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseUser extends Pivot
{
    protected $table = 'course_user';

    protected $fillable = [
        'course_id',
        'user_id',
        'complete',
        'verify',
    ];

    protected $casts = [
        'complete' => 'boolean',
    ];

    // العلاقات إذا تحب تضيفها
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
