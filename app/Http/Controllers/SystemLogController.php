<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message; // Import the Message model

class SystemLogController extends Controller
{
    public function index()
    {
        // Count unread guest messages
        $guestMessageCount = Message::where('isGuestMessage', true)
                                    ->where('IsReadGuest', false)
                                    ->count();

        return view('admin.system-log.index', compact('guestMessageCount'));
    }
}
