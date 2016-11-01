<?php

namespace Boilerplate\Attachment;

/**
 * Class Text
 */
class Gallery extends \City\Attachment\Gallery
{
    /**
     * @return string
     */
    public function type()
    {
        return 'boilerplate/attachment/gallery';
    }
}
