<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'icon_color',
        'description',
        'image'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

   
}