<?php

namespace Boilerplate\Object;

use City\Object\Event as CityEvent;

/**
 * Class Event
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
