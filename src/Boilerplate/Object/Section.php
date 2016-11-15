<?php

namespace Boilerplate\Object;

// Dependencies from `charcoal-city` module
use City\Object\Section as CitySection;

/**
 * Section model
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
