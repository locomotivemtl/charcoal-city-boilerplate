<?php

namespace Boilerplate\Attachment;

// Dependencies from `charcoal-city` module
use City\Attachment\Text as CityText;

/**
 * Text attachment
 */
class Text extends CityText
{
    /**
     * @return string
     */
    public function type()
    {
        return 'boilerplate/attachment/text';
    }
}
