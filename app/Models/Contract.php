<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'terms',
        'start_date',
        'end_date',
        'status',
        'document_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    
    // Add this accessor to automatically calculate status
    public function getStatusAttribute()
    {
        $today = now();
        
        if ($this->attributes['status'] === 'terminated') {
            return 'terminated';
        }
        
        if ($today->lt($this->start_date)) {
            return 'pending';
        }
        
        if ($today->gt($this->end_date)) {
            return 'expired';
        }
        
        return 'active';
    }
}