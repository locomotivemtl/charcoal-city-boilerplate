<?php

namespace Boilerplate\Attachment;

use Charcoal\Translator\Translation;

// Dependencies from `charcoal-attachment` module
use Charcoal\Attachment\Object\Image as ImageAttachment;

/**
 * Image attachment
 */
class Image extends ImageAttachment
{
    /**
     * @var Translation
     */
    protected $caption;

    /**
     * @var Translation
     */
    protected $captionTitle;

    /**
     * @var mixed
     */
    protected $fullWidth;

    // Functions
    // ==========================================================================

    /**
     * @return string
     */
    public function type()
    {
        return 'boilerplate/attachment/image';
    }

    /**
     * @return mixed
     */
    public function hasCaption()
    {
        return isset($this->caption);
    }

    // GETTERS
    // ==========================================================================

    /**
     * @return mixed
     */
    public function caption()
    {
        return $this->caption;
    }

    /**
     * @return mixed
     */
    public function captionTitle()
    {
        return $this->captionTitle;
    }

    /**
     * @return mixed
     */
    public function fullWidth()
    {
        return $this->fullWidth;
    }

    // SETTERS
    // ==========================================================================

    /**
     * @param mixed $caption The image's caption.
     * @return Image
     */
    public function setCaption($caption)
    {
        $this->caption = $this->translator()->translation($caption);

        return $this;
    }

    /**
     * @param mixed $captionTitle The image's caption title.
     * @return Image
     */
    public function setCaptionTitle($captionTitle)
    {
        $this->captionTitle = $this->translator()->translation($captionTitle);

        return $this;
    }

    /**
     * @param mixed $fullWidth Full width.
     * @return Image
     */
    public function setFullWidth($fullWidth)
    {
        $this->fullWidth = $fullWidth;

        return $this;
    }
}
