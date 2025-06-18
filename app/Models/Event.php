<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'start_datetime',
        'end_datetime',
        'venue',
        'city',
        'state',
        'country',
        'organizer_id',
        'status',
        'is_active',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
}
