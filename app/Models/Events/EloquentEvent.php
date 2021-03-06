<?php
namespace EQM\Models\Events;

use EQM\Models\Palmares\EloquentPalmares;
use EQM\Models\Users\EloquentUser;
use Illuminate\Database\Eloquent\Model;

class EloquentEvent extends Model implements Event
{
    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = ['creator_id', 'name', 'place', 'description', 'date'];

    /**
     * @return \EQM\Models\Users\User
     */
    public function creator()
    {
        return $this->belongsTo(EloquentUser::class, 'id', 'creator_id')->first();
    }

    /**
     * @return \EQM\Models\Palmares\Palmares
     */
    public function palmares()
    {
        return $this->hasMany(EloquentPalmares::class, 'palmares_id', 'id')->get();
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function place()
    {
        return $this->place;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * @return \DateTime
     */
    public function startDate()
    {
        return $this->start_date;
    }

    /**
     * @return \DateTime
     */
    public function endDate()
    {
        return $this->end_date;
    }
}
