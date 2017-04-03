<?php

namespace Boilerplate\Attachment;

// Dependencies from `charcoal-attachment` module
use Charcoal\Attachment\Object\Text as TextAttachment;

/**
 * Text attachment
 */
class Text extends TextAttachment
{
    /**
     * @return string
     */
    public function type()
    {
        return 'boilerplate/attachment/text';
    }
}
