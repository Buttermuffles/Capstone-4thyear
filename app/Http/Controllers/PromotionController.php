<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message; // Ensure to import the Message model

class PromotionController extends Controller
{
    public function index()
    {
        // Count guest messages that are unread
        $guestMessageCount = Message::where('isGuestMessage', true)
                                    ->where('IsReadGuest', false)
                                    ->count();

        // Pass the guestMessageCount to the view
        return view('admin.promotions.index', compact('guestMessageCount'));
    }
}
