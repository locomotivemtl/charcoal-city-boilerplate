<?php

namespace Boilerplate\Template\Event;

// Pimple dependencies
use Pimple\Container;

// Module `charcoal-cms` dependencies
use Charcoal\Cms\Support\Interfaces\EventManagerAwareInterface;
use Charcoal\Cms\Support\Traits\DateHelperAwareTrait;
use Charcoal\Cms\Support\Traits\EventManagerAwareTrait;

// Local module dependencies
use Boilerplate\Template\AbstractTemplate;

/**
 * Event index template (event list)
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

        $this->setEventManager($container['cms/event/manager']);
        $this->setDateHelper($container['date/helper']);
    }
}
