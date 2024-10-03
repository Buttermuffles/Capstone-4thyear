<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Message; // Make sure to import your Message model

class DashboardController extends Controller
{
    public function index()
    {
        // Using the correct column for guest messages
     // Count guest messages that are unread
     $guestMessageCount = Message::where('IsReadEmployee', false)
     ->where('IsReadEmployee', 0) // Change this condition
     ->count();
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $totalBooking = Reservation::where('Status', 'Booked')->count();
        $totalReservation = Reservation::where('Status', 'Reserved')->count();

        $availableRooms = $totalRooms - $occupiedRooms;

        $user = Employee::where('Status', 'Active')->count();

        // Fetch today's check-in and check-out counts
        $checkInCount = Reservation::whereDate('DateCheckIn', today())
            ->where('Status', 'Check In')->count();
        $checkOutCount = Reservation::whereDate('DateCheckOut', today())
            ->where('Status', 'Check Out')->count();

            return view('admin.dashboard.index', [
                'totalRooms' => $totalRooms,
                'occupiedRooms' => $occupiedRooms,
                'availableRooms' => $availableRooms,
                'totalBooking' => $totalBooking,
                'totalReservation' => $totalReservation,
                'user' => $user,
                'checkInCount' => $checkInCount,
                'checkOutCount' => $checkOutCount,
                'guestMessageCount' => $guestMessageCount, // Ensure this is included
            ]);
            
    }
}
