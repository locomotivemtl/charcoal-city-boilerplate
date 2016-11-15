<?php

namespace Boilerplate\Attachment;

// Dependencies from `charcoal-city` module
use City\Attachment\Gallery as CityGallery;

/**
 * Gallery attachment
 */
class Gallery extends CityGallery
{
    /**
     * @return string
     */
    public function type()
    {
        return 'boilerplate/attachment/gallery';
    }
}
