<?php

namespace App\Http\Controllers;
use App\Models\Message;
use Illuminate\Http\Request;

class AmenitiesController extends Controller
{
    public function index()
    {
        // Count guest messages that are unread
        $guestMessageCount = Message::where('IsReadEmployee', false)
        ->where('IsReadEmployee', 0) // Change this condition
        ->count();
        return view('admin.amenities.index',compact('guestMessageCount'));
    }
}
