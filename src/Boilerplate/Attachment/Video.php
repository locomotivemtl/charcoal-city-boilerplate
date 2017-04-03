<?php

namespace Boilerplate\Attachment;

// Dependencies from `charcoal-city` module
use Charcoal\Attachment\Object\Video as VideoAttachment;

/**
 * Video attachment
 */
class Video extends VideoAttachment
{
    /**
     * @return string
     */
    public function type()
    {
        return 'boilerplate/attachment/video';
    }
}
