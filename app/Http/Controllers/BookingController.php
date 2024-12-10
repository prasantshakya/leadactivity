<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lead;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display the booking form for the given lead ID.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function createBooking($id)
    {
        // Example: Retrieve the lead details to display in the form if needed
        $lead = Lead::findOrFail($id);
        dd($lead);
        // Pass lead details to the view
       // return view('bookings.create', compact('lead'));
    }
}
