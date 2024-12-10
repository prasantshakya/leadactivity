<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadStatusHistory extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'lead_status_history';

    // Define the fillable columns to prevent mass-assignment vulnerability
    protected $fillable = [
        'lead_id',
        'status_id',
        'substatus_id',
        'notes',
        'created_at',
        'updated_at',
    ];

    // Optionally define the relationship with the Lead model
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    // Optionally define the relationship with the Status model
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
