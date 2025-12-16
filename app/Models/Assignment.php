<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'lecturer_id',
        'deadline'// <--- WAJIB ADA
    ];

    protected $casts = [
        'deadline' => 'datetime', 
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    // Relasi dimatikan dulu atau biarkan saja (tidak masalah)
    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }
}