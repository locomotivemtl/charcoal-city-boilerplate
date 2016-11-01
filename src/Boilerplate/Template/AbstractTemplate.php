<?php

namespace Boilerplate\Template;

// Dependencies from Pimple
use Pimple\Container;

// Dependencies from Charcoal-Support
use Charcoal\Support\Model\ManufacturableModelCollectionTrait;
use Charcoal\Support\Property\ParsableValueTrait;

// Dependencies from Charcoal-City
use City\AbstractCityTemplate;
use City\Support\Traits\SectionLoaderAwareTrait;

/**
 * Class AbstractTemplate
 */
abstract class AbstractTemplate extends AbstractCityTemplate
{
    use ParsableValueTrait;
    use ManufacturableModelCollectionTrait;
    use SectionLoaderAwareTrait;

    /**
     * @param Container $container Pimple/Container.
     * @return void
     */
    public function setDependencies(Container $container)
    {
        parent::setDependencies($container);

        $this->setSectionLoader($container['city/section/loader']);
    }

    /**
     * @return string
     */
    abstract public function templateIdent();
}
