<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Reservation;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
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
        ]);
    }
}
