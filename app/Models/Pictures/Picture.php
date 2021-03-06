<?php
namespace EQM\Models\Pictures;

use EQM\Models\Albums\Album;

interface Picture
{
    const TABLE= 'pictures';
    
    /**
     * @return int
     */
    public function id();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function horse();

    /**
     * @return \EQM\Models\Albums\Album[]
     */
    public function albums();

    /**
     * @return string
     */
    public function path();

    /**
     * @return string
     */
    public function mime();

    /**
     * @return string
     */
    public function originalName();

    /**
     * @return bool
     */
    public function profilePicture();

    /**
     * @return bool
     */
    public function headerImage();

    /**
     * @param \EQM\Models\Albums\Album $album
     */
    public function addToAlbum(Album $album);

    /**
     * @param \EQM\Models\Albums\Album $album
     */
    public function removeFromAlbum(Album $album);

    /**
     * @return bool
     */
    public function isImage();

    /**
     * @return bool
     */
    public function isMovie();

    /**
     * @return \EQM\Models\Companies\Company
     */
    public function company();
}
