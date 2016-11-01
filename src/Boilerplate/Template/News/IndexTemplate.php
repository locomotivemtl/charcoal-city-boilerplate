<?php

namespace Boilerplate\Template\News;

// Pimple dependencies
use Pimple\Container;

// City dependencies
use City\Support\Traits\DateHelperAwareTrait;
use City\Support\Traits\NewsManagerAwareTrait;

// local dependencies
use Boilerplate\Template\AbstractTemplate;

/**
 * Class IndexTemplate
 */
class IndexTemplate extends AbstractTemplate
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

        $this->setNewsManager($container['city/news/manager']);
        $this->setDateHelper($container['date/helper']);
    }
}
