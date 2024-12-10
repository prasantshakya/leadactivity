<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // Fillable fields including 'team_owner'
    protected $fillable = [
        'user_id',
        'employee_id',
        'name',
        'branch_id',
        'department',
        'designation',
        'team_owner', // Ensure this is included
        'joining_date',
        'exit_date',
        'gender',
        'address',
        'mobile',
        'salary_type',
        'salary',
        'created_by',
        'branch_location',
        'bank_identifier_code',
        'bank_name',
        'account_number',
        'account_holder_name',
        'emergency_contact',
    ];

    public static $statuses = [
        'Inactive',
        'Active',
    ];

    // Department relationship
    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department', 'id');
    }

    // Designation relationship
    public function designation()
    {
        return $this->belongsTo('App\Models\Designation', 'designation', 'id');
    }

    // SalaryType relationship
    public function salaryType()
    {
        return $this->belongsTo('App\Models\SalaryType', 'salary_type', 'id');
    }

    // User relationship
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    // Method to check employee's attendance status for a specific date
    public function presentStatus($employee_id, $date)
    {
        return Attendance::where('employee_id', $employee_id)->where('date', $date)->first();
    }
}
