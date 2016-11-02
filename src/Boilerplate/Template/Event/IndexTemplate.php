<?php

namespace Boilerplate\Template\Event;

// Pimple dependencies
use Pimple\Container;

// City dependencies
use City\Support\Interfaces\EventManagerAwareInterface;
use City\Support\Traits\DateHelperAwareTrait;
use City\Support\Traits\EventManagerAwareTrait;

// local dependencies
use Boilerplate\Template\AbstractTemplate;

/**
 * Class IndexTemplate
 */
class IndexTemplate extends AbstractTemplate implements
    EventManagerAwareInterface
{
    use EventManagerAwareTrait;
    use DateHelperAwareTrait;

    /**
     * @return string
     */
    public function templateIdent()
    {
        return 'event-list';
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

        $this->setEventManager($container['city/event/manager']);
        $this->setDateHelper($container['date/helper']);
    }
}
