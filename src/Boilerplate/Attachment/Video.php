<?php

namespace Boilerplate\Attachment;

/**
 * Class Text
 */
class Video extends \City\Attachment\Video
{
    /**
     * @return string
     */
    public function type()
    {
        return 'boilerplate/attachment/video';
    }
}
