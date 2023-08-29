<?php

namespace Database\Seeders;

use App\Models\LeaveCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Sample data for leave categories
        $leaveCategories = [
            [
                'categoryName' => 'Sick Leave',
                'description' => 'Leave for health-related reasons.',
                'available_leaves' => 10,
                'carry_over' => false,
                'max_carry_over_days' => 0
            ],
            [
                'categoryName' => 'Vacation',
                'description' => 'Regular vacation days.',
                'available_leaves' => 15,
                'carry_over' => true,
                'max_carry_over_days' => 10
            ],
            [
                'categoryName' => 'Unpaid Leave',
                'description' => 'Unpaid leave for personal reasons.',
                'available_leaves' => 30,
                'carry_over' => false,
                'max_carry_over_days' => 0
            ],
            // ... add more leave categories as needed
        ];

        // Use Eloquent's insert method to add the data
        foreach ($leaveCategories as $category) {
            LeaveCategory::create($category);
        }
    }
}
