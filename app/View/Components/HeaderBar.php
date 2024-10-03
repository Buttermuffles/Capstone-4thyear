<?php

namespace App\View\Components;

use App\Models\Notification;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderBar extends Component
{
    public $unreadCount;
    public $notifications;

    public function __construct()
    {
        $this->loadNotifications();
    }

    // Load notifications and unread count
    private function loadNotifications()
    {
        $this->notifications = Notification::where('status', 'unread')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $this->unreadCount = $this->notifications->count();
    }

    // Mark notification as read
    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);

        if ($notification) {
            $notification->update(['status' => 'read']); // Update the status
            $this->loadNotifications(); // Reload notifications to update counts
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.header-bar', [
            'unreadCount' => $this->unreadCount,
            'notifications' => $this->notifications,
        ]);
    }
}
