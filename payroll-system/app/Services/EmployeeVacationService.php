<?php

namespace App\Services;

use App\Models\LeaveCategory;
use App\Models\User;

class EmployeeVacationService {
    /**
     * Calculate the remaining leave days for a specific category for an employee.
     */
    public function getRemainingDays(LeaveCategory $category)
    {
        return $category->available_leaves - $category->days_used;
    }

    /**
     * Calculate the number of days an employee can carry over 
     * for a specific category based on the business rules.
     */
    public function getCarryOverDays(LeaveCategory $category)
    {
        if ($category->carry_over) {
            $remainingDays = $this->getRemainingDays($category);
            return ($remainingDays <= $category->max_carry_over_days) ? $remainingDays : $category->max_carry_over_days;
        }
        return 0;
    }

    /**
     * Fetch all leave categories for an employee.
     */
    public function fetchLeaveCategories(User $employee)
    {
        return LeaveCategory::where('employee_id', $employee->id)->get();
    }

    /**
     * Add or update the leave category for an employee.
     * This method assumes $data contains validated data.
     */
    public function saveLeaveCategory(User $employee, array $data)
    {
        // Here you can include any business rules or data manipulation before saving.
        // For simplicity, the method uses the updateOrCreate method, which either updates an existing record or creates a new one.
        $data['employee_id'] = $employee->id;
        return LeaveCategory::updateOrCreate(['id' => $data['id'] ?? null, 'employee_id' => $employee->id], $data);
    }


    /**
     * Remove a leave category for an employee.
     */
    public function removeLeaveCategory(LeaveCategory $category)
    {
        return $category->delete();
    }
}