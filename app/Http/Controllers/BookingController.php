<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message; // Ensure to import the Message model

class BookingController extends Controller
{
    public function index()
    {
        // Count guest messages that are unread
        $guestMessageCount = Message::where('isGuestMessage', true)
                                    ->where('IsReadGuest', false)
                                    ->count();

        // Pass the guestMessageCount to the view
        return view('admin.booking.index', compact('guestMessageCount'));
    }

    public function create()
    {
        // If you need guestMessageCount here, repeat the same logic
        $guestMessageCount = Message::where('isGuestMessage', true)
                                    ->where('IsReadGuest', false)
                                    ->count();

        return view('admin.booking.create', compact('guestMessageCount'));
    }

    public function bookingDetails(Request $request)
    {
        $ReservationId = $request->ReservationId;

        // If you need guestMessageCount here as well
        $guestMessageCount = Message::where('isGuestMessage', true)
                                    ->where('IsReadGuest', false)
                                    ->count();

        return view('admin.booking.booking-details', compact('ReservationId', 'guestMessageCount'));
    }

    public function checkInOut()
    {
        // If you need guestMessageCount here as well
        $guestMessageCount = Message::where('isGuestMessage', true)
                                    ->where('IsReadGuest', false)
                                    ->count();

        return view('admin.booking.check-in-out', compact('guestMessageCount'));
    }
}
