<?php
namespace EQM\Models\Advertising\Advertisements;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class AdvertisementRouteBinding extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Advertising\Advertisements\AdvertisementRepository
     */
    private $advertisements;

    public function __construct(AdvertisementRepository $advertisements)
    {
        $this->advertisements = $advertisements;
    }

    /**
     * @param int|string $slug
     * @return \EQM\Models\Advertising\Advertisements\Advertisement|null
     */
    public function find($slug)
    {
        return $this->advertisements->findById($slug);
    }
}
