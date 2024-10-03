<?php

namespace App\Http\Controllers;
use App\Models\Message;
use Illuminate\Http\Request;

class AmenitiesController extends Controller
{
    public function index()
    {
        $guestMessageCount = Message::where('isGuestMessage', true)->where('IsReadGuest', false)->count();
        return view('admin.amenities.index',compact('guestMessageCount'));
    }
}
