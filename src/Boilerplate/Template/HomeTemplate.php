<?php

namespace Boilerplate\Template;

// Pimple dependencies
use Pimple\Container;

// Module `charcoal-cms` dependencies
use Charcoal\Cms\Support\Interfaces\EventManagerAwareInterface;
use Charcoal\Cms\Support\Traits\EventManagerAwareTrait;
use Charcoal\Cms\Support\Interfaces\NewsManagerAwareInterface;
use Charcoal\Cms\Support\Traits\NewsManagerAwareTrait;
use Charcoal\Cms\Support\Traits\DateHelperAwareTrait;

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

        $this->setNewsManager($container['cms/news/manager']);
        $this->setEventManager($container['cms/event/manager']);
        $this->setDateHelper($container['date/helper']);
    }
}
