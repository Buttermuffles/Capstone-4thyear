<?php

namespace App\Http\Controllers;

use App\Models\Message; // Import the Message model
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        // Count unread guest messages
        $guestMessageCount = Message::where('isGuestMessage', true)
                                    ->where('IsReadGuest', false)
                                    ->count();

        return view('admin.report.index', compact('guestMessageCount'));
    }

    public function downloadReport($id)
    {
        // Count unread guest messages
        $guestMessageCount = Message::where('isGuestMessage', true)
                                    ->where('IsReadGuest', false)
                                    ->count();

        $report = Report::find($id);

        $reservations = Reservation::with(['guest', 'room', 'reservationAmenities', 'checkInOuts'])
            ->whereBetween('DateCreated', [$report->Date, $report->EndDate])
            ->get();

        // Generate the PDF using the reservations and report details
        $pdf = Pdf::loadView('admin.report.sales', compact('reservations', 'report', 'guestMessageCount'));
        return $pdf->stream('invoice.pdf');
    }
}
