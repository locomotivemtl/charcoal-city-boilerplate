<?php

namespace Boilerplate\Template;

// Pimple dependencies
use Pimple\Container;

// Module `charcoal-city` dependencies
use City\Support\Interfaces\EventManagerAwareInterface;
use City\Support\Interfaces\NewsManagerAwareInterface;
use City\Support\Traits\DateHelperAwareTrait;
use City\Support\Traits\EventManagerAwareTrait;
use City\Support\Traits\NewsManagerAwareTrait;

// Local module dependencies
use Boilerplate\Template\AbstractTemplate;

/**
 * Home template
 */
class HomeTemplate extends AbstractTemplate implements
    NewsManagerAwareInterface,
    EventManagerAwareInterface
{
    use NewsManagerAwareTrait;
    use EventManagerAwareTrait;
    use DateHelperAwareTrait;

    /**
     * @return string
     */
    public function templateIdent()
    {
        return 'home';
    }

    // ==========================================================================
    // INIT
    // ==========================================================================

    /**
     * @param Container $container Pimple/Container.
     * @return void
     */
    public function setDependencies(Container $container)
    {
        parent::setDependencies($container);

        $this->setNewsManager($container['city/news/manager']);
        $this->setEventManager($container['city/event/manager']);
        $this->setDateHelper($container['date/helper']);
    }
}
