<?php

namespace Boilerplate\Attachment;

// Dependencies from `charcoal-city` module
use City\Attachment\Image as CityImage;

/**
 * Image attachment
 */
class Image extends CityImage
{
    /**
     * @return string
     */
    public function type()
    {
        return 'boilerplate/attachment/image';
    }
}
