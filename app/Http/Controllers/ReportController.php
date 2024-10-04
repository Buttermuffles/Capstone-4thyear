<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Guest;

class ReportController extends Controller
{
    public function index()
    {
        // Count unread guest messages
        $guestMessageCount = Message::where('IsReadEmployee', false)
            ->orWhere('IsReadEmployee', 0) // Using orWhere for proper condition
            ->count();
    
        // Retrieve guests for the dropdown
        $guests = Guest::all(); // Fetch all guest records
    
        return view('admin.report.index', compact('guestMessageCount', 'guests'));
    }

    public function downloadReport($id)
    {
        // Count guest messages that are unread
        $guestMessageCount = Message::where('IsReadEmployee', false)
            ->orWhere('IsReadEmployee', 0) // Using orWhere for proper condition
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
