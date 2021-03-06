<?php
namespace EQM\Models\Notifications;

use EQM\Models\Users\User;

interface NotificationRepository
{
    /**
     * @param int $id
     * @return \EQM\Models\Notifications\Notification
     */
    public function findById($id);

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Notifications\Notification
     */
    public function findForUser(User $user);

    /**
     * @param \EQM\Models\Users\User $sender
     * @param \EQM\Models\Users\User $receiver
     * @param \EQM\Models\Notifications\Notification|int $type
     * @param $entity
     * @param array $data
     * @return \EQM\Models\Notifications\Notification
     */
    public function create(User $sender, User $receiver, $type, $entity, $data);

    /**
     * @param \EQM\Models\Notifications\Notification $notification
     */
    public function delete(Notification $notification);
}
