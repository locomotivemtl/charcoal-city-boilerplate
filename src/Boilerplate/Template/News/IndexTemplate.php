<?php

namespace Boilerplate\Template\News;

// Pimple dependencies
use Pimple\Container;

// Module `charcoal-city` dependencies
use Charcoal\Cms\Support\Interfaces\NewsManagerAwareInterface;
use Charcoal\Cms\Support\Traits\DateHelperAwareTrait;
use Charcoal\Cms\Support\Traits\NewsManagerAwareTrait;

// Local module dependencies
use Boilerplate\Template\AbstractTemplate;

/**
 * News index template (news list)
 */
class IndexTemplate extends AbstractTemplate implements
    NewsManagerAwareInterface
{
    use NewsManagerAwareTrait;
    use DateHelperAwareTrait;

    /**
     * @return string
     */
    public function templateIdent()
    {
        return 'news-list';
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
        $this->setDateHelper($container['date/helper']);
    }
}
