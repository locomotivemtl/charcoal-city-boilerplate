<?php

namespace Boilerplate\Attachment;

/**
 * Class Text
 */
class Image extends \City\Attachment\Image
{
    /**
     * @return string
     */
    public function type()
    {
        return 'boilerplate/attachment/image';
    }
}
