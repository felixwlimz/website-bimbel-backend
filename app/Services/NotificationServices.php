<?php

namespace App\Services;

use App\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Auth;

class NotificationServices
{
    public function __construct(
        protected NotificationRepository $notificationRepository
    ) {}

    /* =====================================================
     | CREATE
     |=====================================================*/

    public function notifyUser(
        string $userId,
        string $title,
        string $message,
        string $type,
        ?string $actionUrl = null
    ): void {
        $this->notificationRepository->create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'action_url' => $actionUrl,
        ]);
    }

    public function notifyRole(
        string $role,
        string $title,
        string $message,
        string $type,
        ?string $actionUrl = null
    ): void {
        $this->notificationRepository->create([
            'role_target' => $role,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'action_url' => $actionUrl,
        ]);
    }

    /* =====================================================
     | READ
     |=====================================================*/

    public function getMyNotifications()
    {
        $user = Auth::user();

        return $this->notificationRepository
            ->getForUser($user->id, $user->role)
            ->map(fn ($n) => [
                'id' => $n->id,
                'title' => $n->title,
                'message' => $n->message,
                'type' => $n->type,
                'action_url' => $n->action_url,
                'created_at' => $n->created_at,
                'is_read' => $n->reads->isNotEmpty(),
            ]);
    }

    public function countUnread(): int
    {
        $user = Auth::user();

        return $this->notificationRepository
            ->countUnread($user->id, $user->role);
    }

    /* =====================================================
     | UPDATE
     |=====================================================*/

    public function markAsRead(string $notificationId): void
    {
        $this->notificationRepository
            ->markAsRead($notificationId, Auth::id());
    }

    public function markAllAsRead(): void
    {
        $user = Auth::user();

        $this->notificationRepository
            ->markAllAsRead($user->id, $user->role);
    }
}
