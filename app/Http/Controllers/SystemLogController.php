<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message; // Import the Message model

class SystemLogController extends Controller
{
    public function index()
    {
        // Count unread guest messages
        $guestMessageCount = Message::where('IsReadEmployee', false)
        ->where('IsReadEmployee', 0) // Change this condition
        ->count();

        return view('admin.system-log.index', compact('guestMessageCount'));
    }
}
