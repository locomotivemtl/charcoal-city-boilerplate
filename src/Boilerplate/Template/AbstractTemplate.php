<?php

namespace Boilerplate\Template;

// Dependencies from Pimple
use Boilerplate\Object\Section;
use Charcoal\Model\ModelInterface;
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
     * @param ModelInterface $context The current context.
     * @return AbstractCityTemplate
     */
    public function setContextObject(ModelInterface $context)
    {
        if ($context instanceof Section) {
            $this->setSection($context);
        }

        return parent::setContextObject($context);
    }

    /**
     * @return string
     */
    abstract public function templateIdent();
}
