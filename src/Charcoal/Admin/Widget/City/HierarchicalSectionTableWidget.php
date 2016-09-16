<?php

namespace Charcoal\Admin\Widget\City;

use Pimple\Container;

// From 'charcoal-support'
use Charcoal\Support\Container\DependentInterface;
use Charcoal\Support\Admin\Widget\HierarchicalTableWidget;

/**
 * The hierarchical table widget displays a collection in a tabular (table) format.
 */
class HierarchicalSectionTableWidget extends HierarchicalTableWidget implements
    DependentInterface
{
    use SectionTableTrait;

    /**
     * Inject dependencies from a DI Container.
     *
     * @param  Container $container A dependencies container instance.
     * @return void
     */
    public function setDependencies(Container $container)
    {
        parent::setDependencies($container);

        $this->setSectionFactory($container['city/section/factory']);
    }
}
