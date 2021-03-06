<?php
namespace EQM\Models\Pictures;

use EQM\Models\Companies\Company;
use EQM\Models\Horses\Horse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EloquentPictureRepository implements PictureRepository
{
    /**
     * @var \EQM\Models\Pictures\EloquentPicture
     */
    private $picture;

    /**
     * @param \EQM\Models\Pictures\EloquentPicture $picture
     */
    public function __construct(EloquentPicture $picture)
    {

        $this->picture = $picture;
    }

    /**
     * @param int $id
     * @return \EQM\Models\Pictures\Picture
     */
    public function findById($id)
    {
        return $this->picture->where('id', $id)->first();
    }

    /**
     * @param string $path
     * @return \EQM\Models\Pictures\Picture
     */
    public function findByPath($path)
    {
        return $this->picture->where('path', $path)->firstOrFail();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param \EQM\Models\Horses\Horse|null $horse
     * @param bool $profile
     * @param string $fileName
     * @param string $extension
     * @return \EQM\Models\Pictures\Picture
     */
    public function create(UploadedFile $file, Horse $horse = null, $profile, $fileName, $extension)
    {
        $picture = new EloquentPicture();
        $picture->path = $fileName . '.' . $extension;
        $picture->horse_id = $horse ? $horse->id() : null;
        $picture->mime = $file->getClientMimeType();
        $picture->original_name = $file->getClientOriginalName();
        $picture->profile_pic = $profile;

        $picture->save();

        return $picture;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param \EQM\Models\Companies\Company $company
     * @param string $fileName
     * @param string $extension
     * @return \EQM\Models\Pictures\Picture
     */
    public function createForCompany(UploadedFile $file, Company $company, $fileName, $extension)
    {
        $picture = new EloquentPicture();
        $picture->path = $fileName . '.' . $extension;
        $picture->horse_id = null;
        $picture->mime = $file->getClientMimeType();
        $picture->original_name = $file->getClientOriginalName();
        $picture->profile_pic = false;
        $picture->company_id = $company->id();

        $picture->save();

        return $picture;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param \EQM\Models\Horses\Horse $horse
     * @param string $fileName
     * @param string $extension
     * @return \EQM\Models\Pictures\Picture
     */
    public function createVideo(UploadedFile $file, Horse $horse, $fileName, $extension)
    {
        $picture = new EloquentPicture();
        $picture->path = $fileName;
        $picture->horse_id = $horse->id();
        $picture->mime = $file->getClientMimeType();
        $picture->original_name = $file->getClientOriginalName();
        $picture->profile_pic = false;

        $picture->save();

        return $picture;
    }

    /**
     * @param \EQM\Models\Pictures\Picture $picture
     */
    public function delete(Picture $picture)
    {
        $picture->delete();
    }

    /**
     * @return int
     */
    public function count()
    {
        return (count($this->picture->all()));
    }
}
