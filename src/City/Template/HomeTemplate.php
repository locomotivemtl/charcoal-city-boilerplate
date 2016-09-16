<?php

namespace City\Template;

use City\AbstractCityTemplate;

/**
 * City Home Template Controller.
 */
class HomeTemplate extends AbstractCityTemplate
{
    /**
     * @return string
     */
    public function test()
    {
        return 'TEST '.rand(0, 100);
    }
}
