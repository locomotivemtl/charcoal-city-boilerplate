<?php

namespace Boilerplate\Attachment;

/**
 * Class Text
 */
class Text extends \City\Attachment\Text
{
    /**
     * @return string
     */
    public function type()
    {
        return 'boilerplate/attachment/text';
    }
}
