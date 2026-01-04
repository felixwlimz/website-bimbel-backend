<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Models\NotificationRead;

class NotificationRepository
{
    /* =====================================================
     | CREATE
     |=====================================================*/

    public function create(array $data): Notification
    {
        return Notification::create($data);
    }

    /* =====================================================
     | QUERY
     |=====================================================*/

    public function getForUser(string $userId, string $role)
    {
        return Notification::query()
            ->where(function ($q) use ($userId, $role) {
                $q->where('user_id', $userId)
                  ->orWhere('role_target', $role);
            })
            ->with([
                'reads' => fn ($q) =>
                    $q->where('user_id', $userId),
            ])
            ->latest()
            ->get();
    }

    public function countUnread(string $userId, string $role): int
    {
        return Notification::query()
            ->where(function ($q) use ($userId, $role) {
                $q->where('user_id', $userId)
                  ->orWhere('role_target', $role);
            })
            ->whereDoesntHave('reads', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->count();
    }

    /* =====================================================
     | READ STATUS
     |=====================================================*/

    public function markAsRead(string $notificationId, string $userId): void
    {
        NotificationRead::firstOrCreate(
            [
                'notification_id' => $notificationId,
                'user_id' => $userId,
            ],
            [
                'read_at' => now(),
            ]
        );
    }

    public function markAllAsRead(string $userId, string $role): void
    {
        $ids = Notification::query()
            ->where(function ($q) use ($userId, $role) {
                $q->where('user_id', $userId)
                  ->orWhere('role_target', $role);
            })
            ->pluck('id');

        foreach ($ids as $id) {
            NotificationRead::firstOrCreate(
                [
                    'notification_id' => $id,
                    'user_id' => $userId,
                ],
                [
                    'read_at' => now(),
                ]
            );
        }
    }
}
