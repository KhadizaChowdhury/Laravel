<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'leave_category_id',
        'start_date',
        'end_date',
        'number_of_days',
        'reason',
        'status',
        'approved_by',
        'approved_at',
    ];

    /**
     * A leave request belongs to a user (employee).
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A leave request belongs to a leave category.
     *
     */
    public function leaveCategory()
    {
        return $this->belongsTo(LeaveCategory::class);
    }
    public function leaveReport()
    {
        return $this->belongsTo(LeaveReport::class);
    }

    /**
     * If a leave request is approved, it might have an approver.
     *
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
