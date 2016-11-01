<?php

namespace Charcoal\Admin\Property\Input\Tinymce;

use Charcoal\Admin\Property\Input\TinymceInput;

/**
 * Class ContentInput
 */
class ContentInput extends TinymceInput
{
    /**
     * ContentInput constructor.
     * @param array|null $data Dependencies.
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);

        $defaultData = $this->metadata()->defaultData();
        if ($defaultData) {
            $this->setData($defaultData);
        }
    }
}
