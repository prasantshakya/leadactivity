<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Define the table name if it's different from the plural of the model name
    protected $table = 'bookings';

    // Specify the fields that can be mass-assigned
    protected $fillable = [
        'lead_id',
        'date_of_booking',
        'project_name',
        'developer_name',
        'source_of_funds',
        'unit_number',
        'pan_number',
        'area',
        'measure',
        'scheme',
        'booking_docs',
        'kyc_docs',
        'created_by'
    ];

    // Relationships

    /**
     * Get the user who created the booking.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the lead associated with the booking.
     */
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
}
