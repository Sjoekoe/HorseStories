<?php
namespace EQM\Models\Notifications;

use Carbon\Carbon;
use EQM\Models\Users\EloquentUser;
use Illuminate\Database\Eloquent\Model;

class EloquentNotification extends Model implements Notification
{
    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = ['type', 'link'];

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function link()
    {
        return $this->link;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function senderRelation()
    {
        return $this->hasOne(EloquentUser::class, 'id', 'sender_id');
    }

    /**
     * @return \EQM\Models\Users\User
     */
    public function sender()
    {
        return $this->senderRelation()->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function receiverRelation()
    {
        return $this->hasOne(EloquentUser::class, 'id', 'receiver_id');
    }

    /**
    * @return \EQM\Models\Users\User
    */
    public function receiver()
    {
        return $this->receiverRelation()->first();
    }

    /**
     * @return mixed
     */
    public function isRead()
    {
        return $this->read;
    }

    /**
     * @return bool
     */
    public function isUnread()
    {
        return ! $this->isRead();
    }

    public function markAsRead()
    {
        $this->read = true;
        $this->save();
    }

    /**
     * @param static $type
     * @param $entity
     * @return string
     */
    public function getRoute($type, $entity)
    {
        switch ($type) {
            case self::STATUS_LIKED:
                return route('statuses.show', $entity->id());

            case self::COMMENT_POSTED;
                return route('statuses.show', $entity->id());

            case self::PEDIGREE_CREATED:
                return route('horses.show', $entity->slug());

            case self::COMMENT_LIKED:
                return route('statuses.show', $entity->id());

            case self::HORSE_FOLLOWED:
                return route('users.profiles.show', $entity->slug());
        }
    }

    /**
     * @return string
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * @return \Carbon\Caron
     */
    public function createdAt()
    {
        return Carbon::instance($this->created_at);
    }
}
