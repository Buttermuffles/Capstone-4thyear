<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\UserAccount;
use App\Models\Message; // Import the Message model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Count unread guest messages
        $guestMessageCount = Message::where('isGuestMessage', true)
                                    ->where('IsReadGuest', false)
                                    ->count();
        
        return view('admin.user.index', compact('guestMessageCount'));
    }

    public function addUser()
    {
        return view('admin.user.add');
    }

    public function updateUser($userId)
    {
        $employee = Employee::where('EmployeeId', $userId)->firstOrFail();
        return view('admin.user.update', compact('employee'));
    }

    public function settings()
    {
        $user = Auth::user();
        return view('admin.user.setting', compact('user'));
    }
}
