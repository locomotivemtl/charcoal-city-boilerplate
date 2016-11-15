<?php

namespace Boilerplate\Object;

// Dependencies from `charcoal-city` module
use City\Object\News as CityNews;

/**
 * News model
 */
class News extends CityNews
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
