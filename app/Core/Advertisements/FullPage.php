<?php
namespace EQM\Core\Advertisements;

class FullPage implements AdObject
{
    public function name()
    {
        return 'Full Page';
    }

    public function type()
    {
        return self::FULL_PAGE;
    }

    public function width()
    {
        return '1920';
    }

    public function height()
    {
        return '1200';
    }

    public function price()
    {
        return '100';
    }
}
