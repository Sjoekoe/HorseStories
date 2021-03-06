<?php
namespace EQM\Models\Statuses;

use EQM\Core\Files\Uploader;
use EQM\Models\Albums\Album;
use EQM\Models\Albums\AlbumRepository;
use EQM\Models\Companies\Company;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseRepository;

class StatusCreator
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @var \EQM\Models\Albums\AlbumRepository
     */
    private $albums;

    /**
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Core\Files\Uploader $uploader
     * @param \EQM\Models\Albums\AlbumRepository $albums
     */
    public function __construct(
        StatusRepository $statuses,
        HorseRepository $horses,
        Uploader $uploader,
        AlbumRepository $albums
    ) {
        $this->statuses = $statuses;
        $this->horses = $horses;
        $this->uploader = $uploader;
        $this->albums = $albums;
    }

    /**
     * @param array $values
     * @return \EQM\Models\Statuses\Status
     */
    public function create($values)
    {
        $horse = $this->horses->findById($values['horse']);
        $status = $this->statuses->create($horse, $values['body']);

        $this->addPicture($horse, $status, $values);
        $this->addMovie($horse, $status, $values);

        return $status;
    }

    public function createForPalmares(Horse $horse, $values)
    {
        $status = $this->statuses->createForPalmares($horse, $values['body']);

        $this->addPicture($horse, $status, $values);
        $this->addMovie($horse, $status, $values);

        return $status;
    }

    public function createForFollowingCompany(Horse $horse, Company $company)
    {
        $values['body'] = '<a href="/companies/' . $company->slug() . '" class="text-mint">' . $company->name() . '</a>';
        $values['body'] .= '<br><br>';
        $values['body'] .= $company->about();
        $link = route('companies.show', $company->slug());

        $status = $this->statuses->createForFollowingCompany($horse, $values, $link);

        return $status;
    }

    private function addPicture(Horse $horse, Status $status, array $values)
    {
        if (array_key_exists('picture', $values) && $values['picture'] !== 'undefined') {
            $picture = $this->uploader->uploadPicture($values['picture'], $horse);

            if (! $horse->getStandardAlbum(Album::TIMELINEPICTURES)) {
                $album = $this->albums->createStandardAlbum($horse, Album::TIMELINEPICTURES, 'timeline_album');
            } else {
                $album = $horse->getStandardAlbum(Album::TIMELINEPICTURES);
            }

            $picture->addToAlbum($album);
            $status->setPicture($picture);

            $status->save();
        }
    }

    private function addMovie(Horse $horse, Status $status, $values)
    {
        if (array_key_exists('movie', $values)) {
            $movie = $this->uploader->uploadMovie($values['movie'], $horse);

            $status->setPicture($movie);

            $status->save();
        }
    }
}
