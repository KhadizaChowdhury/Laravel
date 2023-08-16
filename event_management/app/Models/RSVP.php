<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RSVP extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'event_id',
        'status'
    ];


    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
