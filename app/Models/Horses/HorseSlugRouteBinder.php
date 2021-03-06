<?php
namespace EQM\Models\Horses;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class HorseSlugRouteBinder extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @param \EQM\Models\Horses\HorseRepository $horses
     */
    public function __construct(HorseRepository $horses)
    {
        $this->horses = $horses;
    }

    /**
     * @param int|string $slug
     * @return mixed
     */
    public function find($slug)
    {
        $horse = $this->horses->findBySlug($slug);

        return $this->horses->findBySlug($slug);
    }
}
