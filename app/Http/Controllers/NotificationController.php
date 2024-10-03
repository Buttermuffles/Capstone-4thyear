<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if ($notification) {
            $notification->update(['status' => 'read']);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
