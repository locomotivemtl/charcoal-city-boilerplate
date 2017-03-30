<?php

namespace Boilerplate\Attachment;

// Dependencies from `charcoal-attachment` module
use Charcoal\Attachment\Object\Gallery as GalleryAttachment;

/**
 * Gallery attachment
 */
class Gallery extends GalleryAttachment
{
    /**
     * @return string
     */
    public function type()
    {
        return 'boilerplate/attachment/gallery';
    }
}
