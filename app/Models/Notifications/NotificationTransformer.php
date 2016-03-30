<?php
namespace EQM\Models\Notifications;

use EQM\Api\Users\UserTransformer;
use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'sender',
        'receiver',
    ];

    public function transform(Notification $notification)
    {
        return [
            'id' => $notification->id(),
            'type' => $notification->type(),
            'url' => route('notifications.show', $notification->id()),
            'message' => trans('notifications.' . $notification->type(), json_decode($notification->data(), true)),
            'is_read' => (bool) $notification->isRead(),
            'icon' => config('notifications.' . $notification->type()),
            'created_at' => $notification->createdAt()->toIso8601String(),
        ];
    }

    public function includeSender(Notification $notification)
    {
        return $this->item($notification->sender()->first(), new UserTransformer());
    }

    public function includeReceiver(Notification $notification)
    {
        return $this->item($notification->receiver()->first(), new UserTransformer());
    }
}
