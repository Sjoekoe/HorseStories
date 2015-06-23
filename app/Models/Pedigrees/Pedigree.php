<?php
namespace HorseStories\Models\Pedigrees;

use Illuminate\Database\Eloquent\Model;

class Pedigree extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['horse_id', 'type', 'family_name', 'family_life_number', 'family_id', 'date_of_birth', 'date_of_death', 'color', 'height', 'breed'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horse()
    {
        return $this->belongsTo('HorseStories\Models\Horses\Horse');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function originalHorse()
    {
        return $this->hasOne('HorseStories\Models\Horses\Horse', 'id', 'family_id');
    }
}