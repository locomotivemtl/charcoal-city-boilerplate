<?php

namespace Boilerplate\Object;

use City\Object\Section as CitySection;

/**
 * Class News
 */
class Section extends CitySection
{
    /**
     * Section constructor.
     * @param array $data The data.
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);

        if (is_callable([$this, 'defaultData'])) {
            $this->setData($this->defaultData());
        }
    }
}
