<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'date',
        'time',
        'location',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function rsvp(){
        return $this->hasMany(RSVP::class);
    }

}
