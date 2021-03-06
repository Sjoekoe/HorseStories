<?php
namespace EQM\Models\Horses;

use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;
use Carbon\Carbon;
use EQM\Core\Search\CanBeSearched;
use EQM\Core\Search\Searchable;
use EQM\Models\Albums\EloquentAlbum;
use EQM\Models\Companies\Company;
use EQM\Models\Companies\EloquentCompany;
use EQM\Models\Companies\Horses\EloquentCompanyHorse;
use EQM\Models\Disciplines\EloquentDiscipline;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\Palmares\EloquentPalmares;
use EQM\Models\Pedigrees\EloquentPedigree;
use EQM\Models\Pedigrees\Pedigree;
use EQM\Models\Pictures\EloquentPicture;
use EQM\Models\Statuses\EloquentHorseStatus;
use EQM\Models\Users\EloquentUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentHorse extends Model implements Horse
{
    use AlgoliaEloquentTrait;

    /**
     * The table name used by the entity
     *
     * @var string
     */
    protected $table = 'horses';

    /**
     * The fillable fields in the database
     *
     * @var array
     */
    protected $fillable = [
        'name', 'gender', 'breed', 'height', 'date_of_birth', 'color', 'life_number', 'user_id'
    ];

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
        return ucfirst(strtolower($this->name));
    }

    /**
     * @return string
     */
    public function slug()
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function gender()
    {
        return $this->gender;
    }

    /**
     * @return int
     */
    public function breed()
    {
        return $this->breed;
    }

    /**
     * @return string
     */
    public function height()
    {
        return $this->height;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function dateOfBirth()
    {
        return $this->date_of_birth ? Carbon::createFromTimestamp(strtotime($this->date_of_birth)) : '';
    }

    /**
     * @return int
     */
    public function color()
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function lifeNumber()
    {
        return $this->life_number;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userTeams()
    {
        return $this->hasMany(EloquentHorseTeam::class, 'horse_id', 'id');
    }

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function users()
    {
        $users = [];

        foreach($this->userTeams as $team) {
            array_push($users, $team->user()->first());
        }

        return $users;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany(EloquentHorseStatus::class, 'horse_id', 'id')->latest()->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected function picturesRelation()
    {
        return $this->hasMany(EloquentPicture::class, 'horse_id', 'id');
    }

    /**
     * @return \EQM\Models\Pictures\Picture[]
     */
    public function pictures()
    {
        return $this->picturesRelation()->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(EloquentUser::class, 'follows', 'horse_id', 'user_id')->withTimestamps()->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function palmaresRelation()
    {
        return $this->hasMany(EloquentPalmares::class, 'horse_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function palmares()
    {
        return $this->palmaresRelation()->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pedigree()
    {
        return $this->hasMany(EloquentPedigree::class, 'horse_id', 'id')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function family()
    {
        return $this->hasManyThrough(EloquentHorse::class, EloquentPedigree::class, 'family_id', 'id');
    }

    /**
     * @return \EQM\Models\Disciplines\Discipline[]
     */
    public function disciplines()
    {
        return $this->disciplineRelation()->get();
    }

    private function disciplineRelation()
    {
        return $this->hasMany(EloquentDiscipline::class, 'horse_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function albums()
    {
        return $this->hasMany(EloquentAlbum::class, 'horse_id', 'id')->get();
    }

    /**
     * @return \EQM\Models\Horses\EloquentHorse
     */
    public function father()
    {
        $pedigree =  $this->pedigree()->filter(function ($family) {
            return $family->type == 1;
        })->first();

        return $pedigree ? $pedigree->originalHorse : null;
    }

    /**
     * @return bool
     */
    public function hasFather()
    {
        return $this->father() !== null;
    }

    /**
     * @return \EQM\Models\Horses\EloquentHorse
     */
    public function fathersFather()
    {
        return $this->father()->father();
    }

    /**
     * @return \EQM\Models\Horses\EloquentHorse
     */
    public function fathersMother()
    {
        return $this->father()->mother();
    }

    /**
     * @return \EQM\Models\Horses\EloquentHorse
     */
    public function mother()
    {
        $pedigree =  $this->pedigree()->filter(function ($family) {
            return $family->type == 2;
        })->first();

        return $pedigree ? $pedigree->originalHorse : null;
    }

    /**
     * @return bool
     */
    public function hasMother()
    {
        return $this->mother() !== null;
    }

    /**
     * @return \EQM\Models\Horses\EloquentHorse
     */
    public function mothersFather()
    {
        return $this->mother() ? $this->mother()->father() : null;
    }

    /**
     * @return \EQM\Models\Horses\EloquentHorse
     */
    public function mothersMother()
    {
        return $this->mother()->mother();
    }

    /**
     * @return \EQM\Models\Pictures\Picture
     */
    public function getProfilePicture()
    {
        return $this->picturesRelation->filter(function ($picture) {
            return $picture->profilePicture() == true;
        })->first();
    }

    /**
     * @return \EQM\Models\Pictures\Picture
     */
    public function getHeaderImage()
    {
        return $this->picturesRelation->filter(function ($picture) {
            return $picture->headerImage() == true;
        })->first();
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getBirthDay()
    {
        return $this->dateOfBirth()->format('d/m/Y');
    }

    /**
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    public function sons()
    {
        return $this->pedigree()->filter(function($family) {
            return $family->type == Pedigree::SON;
        })->all();
    }

    /**
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    public function daughters()
    {
        return $this->pedigree()->filter(function($family) {
            return $family->type == Pedigree::DAUGHTER;
        })->all();
    }

    /**
     * @param int $disciplineId
     * @return bool
     */
    public function performsDiscipline($disciplineId)
    {
        return $this->disciplines()->filter(function($discipline) use ($disciplineId) {
           return $discipline->discipline === $disciplineId;
        })->first();
    }

    /**
     * @return bool
     */
    public function isFemale()
    {
        return $this->gender == self::MARE;
    }

    /**
     * @param int $type
     * @return \EQM\Models\Albums\Album
     */
    public function getStandardAlbum($type)
    {
        foreach($this->albums() as $album) {
            if ($album->type() && ($album->type() === $type)) {
                return $album;
            }
        }
    }

    /**
     * @return string
     */
    public function wistiaKey()
    {
        return $this->wistia_project_id;
    }

    /**
     * @return bool
     */
    public function hasWistiaKey()
    {
        return $this->wistiaKey() !== null;
    }

    public function companyRelation()
    {
        return $this->belongsToMany(EloquentCompany::class, EloquentCompanyHorse::TABLE, 'horse_id', 'company_id');
    }

    /**
     * @return \EQM\Models\Companies\Company[]
     */
    public function companies()
    {
        return $this->companyRelation()->get();
    }

    /**
     * @param \EQM\Models\Companies\Company $company
     * @return bool
     */
    public function isFollowingCompany(Company $company)
    {
        foreach ($this->companies() as $horseCompany) {
            if ($horseCompany->id() == $company->id()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return \EQM\Models\Horses\Horse[]
     */
    public function brothers()
    {
        $result = new Collection();

        if ($this->father()) {
            foreach ($this->father()->sons() as $son) {
                $horse = $son->originalHorse()->first();

                if ($horse->id() !== $this->id()) {
                    $result->push($son->originalHorse()->first());
                }
            }
        }

        if ($this->mother()) {
            foreach ($this->mother()->sons() as $son) {
                $horse = $son->originalHorse()->first();

                if ($horse->id() !== $this->id()) {
                    $result->push($son->originalHorse()->first());
                }
            }
        }

        return $result;
    }

    /**
     * @return \EQM\Models\Horses\Horse[]
     */
    public function sisters()
    {
        $result = new Collection();

        if ($this->father()) {
            foreach ($this->father()->daughters() as $daughter) {
                $horse = $daughter->originalHorse()->first();

                if ($horse->id() !== $this->id()) {
                    $result->push($daughter->originalHorse()->first());
                }
            }
        }

        if ($this->mother()) {
            foreach ($this->mother()->daughters() as $daughter) {
                $horse = $daughter->originalHorse()->first();

                if ($horse->id() !== $this->id()) {
                    $result->push($daughter->originalHorse()->first());
                }
            }
        }

        return $result;
    }
}
