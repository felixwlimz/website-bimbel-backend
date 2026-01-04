<?php

namespace App\Http\Controllers;

use App\Services\NotificationServices;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationServices $notificationService
    ) {}

    /**
     * GET /notifications
     */
    public function index()
    {
        return response()->json([
            'data' => $this->notificationService->getMyNotifications(),
        ]);
    }

    /**
     * GET /notifications/unread-count
     */
    public function unreadCount()
    {
        return response()->json([
            'count' => $this->notificationService->countUnread(),
        ]);
    }

    /**
     * POST /notifications/{id}/read
     */
    public function markAsRead(string $id)
    {
        $this->notificationService->markAsRead($id);

        return response()->json([
            'message' => 'Notification marked as read',
        ]);
    }

    /**
     * POST /notifications/read-all
     */
    public function markAllAsRead()
    {
        $this->notificationService->markAllAsRead();

        return response()->json([
            'message' => 'All notifications marked as read',
        ]);
    }
}
