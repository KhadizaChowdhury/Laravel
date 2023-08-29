<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoryName',
        'description',
        'available_leaves',
        'carry_over',
        'max_carry_over_days',
        'days_used'
    ];


    /**
     * A leave category can have many leave requests.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function getRemainingDays()
    {
        return $this->available_leaves - $this->days_used;
    }

    public function getCarryOverDays()
    {
        if ($this->carry_over) {
            return ($this->getRemainingDays() <= $this->max_carry_over_days) ? $this->getRemainingDays() : $this->max_carry_over_days;
        }
        return 0;
    }
}
