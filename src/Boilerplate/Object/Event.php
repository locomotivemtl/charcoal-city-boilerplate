<?php

namespace Boilerplate\Object;

// Dependencies from `charcoal-city` module
use City\Object\Event as CityEvent;

/**
 * Event model
 */
class Event extends CityEvent
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
