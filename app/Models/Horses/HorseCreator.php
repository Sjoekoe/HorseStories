<?php
namespace EQM\Models\Horses;

use EQM\Core\Files\Uploader;
use EQM\Core\Slugs\SlugCreator;
use EQM\Events\HorseWasCreated;
use EQM\Models\Albums\Album;
use EQM\Models\Disciplines\DisciplineRepository;
use EQM\Models\HorseTeams\HorseTeamRepository;
use EQM\Models\Users\User;
use Illuminate\Events\Dispatcher;

class HorseCreator
{
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Models\Disciplines\DisciplineRepository
     */
    private $disciplines;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @var \EQM\Core\Slugs\SlugCreator
     */
    private $slugCreator;

    /**
     * @var \EQM\Models\HorseTeams\HorseTeamRepository
     */
    private $horseTeams;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    private $dispatcher;

    /**
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Disciplines\DisciplineRepository $disciplines
     * @param \EQM\Core\Files\Uploader $uploader
     * @param \EQM\Core\Slugs\SlugCreator $slugCreator
     * @param \EQM\Models\HorseTeams\HorseTeamRepository $horseTeams
     * @param \Illuminate\Events\Dispatcher $dispatcher
     */
    public function __construct(
        HorseRepository $horses,
        DisciplineRepository $disciplines,
        Uploader $uploader,
        SlugCreator $slugCreator,
        HorseTeamRepository $horseTeams,
        Dispatcher $dispatcher
    ) {
        $this->horses = $horses;
        $this->disciplines = $disciplines;
        $this->uploader = $uploader;
        $this->slugCreator = $slugCreator;
        $this->horseTeams = $horseTeams;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @return \EQM\Models\Horses\Horse
     */
    public function create(User $user, $values)
    {
        if ($values['life_number'] && $horse = $this->horses->findByLifeNumber($values['life_number'])) {
            $horse = $this->horses->update($horse, $values);

            $this->resolveDisciplines($horse, $values);
        } else {
            $horse = $this->horses->create($values);

            $horse->slug = $this->slugCreator->createForHorse($values['name']);

            if (array_key_exists('disciplines', $values)) {
                $this->addDisciplines($horse, $values);
            }
        }

        if ($values['profile_pic']) {
            $picture = $this->uploader->uploadPicture($values['profile_pic'], $horse, true);

            $picture->addToAlbum($horse->getStandardAlbum(Album::PROFILEPICTURES));
        }

        $this->horseTeams->createOwner($user, $horse);
        $horse->save();

        $this->dispatcher->fire(new HorseWasCreated($horse));

        return $horse;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     */
    private function resolveDisciplines(Horse $horse, $values = [])
    {
        $initialDisciplines = [];
        $unwantedDisciplines = [];

        foreach ($horse->disciplines as $initialDiscipline) {
            $initialDisciplines[$initialDiscipline->id] = $initialDiscipline->discipline;
        }

        if (array_key_exists('disciplines', $values)) {
            $this->addDisciplines($horse, $values);

            $unwantedDisciplines = array_diff($initialDisciplines, $values['disciplines']);
        }

        foreach ($unwantedDisciplines as $key => $values) {
            $this->disciplines->removeById($key);
        }
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     */
    private function addDisciplines(Horse $horse, array $values)
    {
        foreach ($values['disciplines'] as $discipline) {
            $horse->disciplines()->updateOrCreate(['discipline' => $discipline, 'horse_id' => $horse->id]);
        }
    }
}
