<?php

namespace Boilerplate\Attachment;

use Charcoal\Attachment\Object\Image as AttachmentImage;

/**
 * Class Text
 */
class TextImage extends AttachmentImage
{
    /**
     * @return string
     */
    public function type()
    {
        return 'boilerplate/attachment/text-image';
    }

    /**
     * @return boolean
     */
    public function isTextImage()
    {
        return true;
    }

    /**
     * @return string
     */
    public function glyphicon()
    {
        return 'glyphicon-font';
    }
}
