<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomPictures;
use App\Models\Message; // Import the Message model
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class RoomController extends Controller
{
    public function index()
    {
        // Count unread guest messages
        $guestMessageCount = Message::where('IsReadEmployee', false)
        ->where('IsReadEmployee', 0) // Change this condition
        ->count();

        return view('admin.room.index', compact('guestMessageCount'));
    }

    public function addRoom()
    {
        // Count unread guest messages
        $guestMessageCount = Message::where('IsReadEmployee', false)
        ->where('IsReadEmployee', 0) // Change this condition
        ->count();

        return view('admin.room.add', compact('guestMessageCount'));
    }

    public function updateRoom($roomId)
    {
        try {
            $decryptedId = Crypt::decrypt($roomId);
            $room = Room::findOrFail($decryptedId);
            // Count unread guest messages
            $guestMessageCount = Message::where('IsReadEmployee', false)
            ->where('IsReadEmployee', 0) // Change this condition
            ->count();

            return view('admin.room.update', compact('room', 'guestMessageCount'));
        } catch (DecryptException $e) {
            return redirect()->route('admin.room.index')->with('error', 'Invalid Room ID.');
        }
    }

    public function viewRoom($roomId)
    {
        try {
            $decryptedId = Crypt::decrypt($roomId);
            $room = Room::findOrFail($decryptedId);
            // Count unread guest messages
            $guestMessageCount = Message::where('IsReadEmployee', false)
            ->where('IsReadEmployee', 0) // Change this condition
            ->count();
            return view('admin.room.view', compact('room', 'guestMessageCount'));
        } catch (DecryptException $e) {
            return redirect()->route('admin.room.index')->with('error', 'Invalid Room ID.');
        }
    }

    public function receptionistIndex()
    {
        // Count unread guest messages
        $guestMessageCount = Message::where('IsReadEmployee', false)
        ->where('IsReadEmployee', 0) // Change this condition
        ->count();

        return view('admin.room.receptionist-room', compact('guestMessageCount'));
    }
}
