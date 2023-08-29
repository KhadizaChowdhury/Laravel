<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveReport extends Model
{
    use HasFactory;

    // The attributes that are mass assignable
    protected $fillable = [
        'user_id',
        'approved_by',
        'total_leaves_taken',
        'vacation_leaves_taken',
        'unpaid_leaves_taken',
        'sick_leaves_taken',
        'comments',
    ];

    // Get the user (employee) associated with the leave report
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function request()
    {
        return $this->belongsTo(LeaveRequest::class);
    }

    // Get the manager who reviewed/approved the report
    public function manager()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
