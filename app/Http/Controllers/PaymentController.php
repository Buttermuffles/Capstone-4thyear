<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message; // Ensure to import the Message model

class PaymentController extends Controller
{
    public function index()
    {
        // Count guest messages that are unread
     // Count guest messages that are unread
     $guestMessageCount = Message::where('IsReadEmployee', false)
     ->where('IsReadEmployee', 0) // Change this condition
     ->count();

        // Pass the guestMessageCount to the view
        return view('admin.payment.index', compact('guestMessageCount'));
    }
}
