<?php

namespace Boilerplate\Attachment;

// Dependencies from `charcoal-city` module
use City\Attachment\Video as CityVideo;

/**
 * Video attachment
 */
class Video extends CityVideo
{
    /**
     * @return string
     */
    public function type()
    {
        return 'boilerplate/attachment/video';
    }
}
