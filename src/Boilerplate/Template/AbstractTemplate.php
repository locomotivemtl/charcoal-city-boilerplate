<?php

namespace Boilerplate\Template;

// Dependencies from Pimple
use Boilerplate\Object\Section;
use Charcoal\Model\ModelInterface;
use City\Support\Interfaces\BreadcrumbAwareInterface;
use City\Support\Traits\BreadcrumbAwareTrait;
use Pimple\Container;

// Dependencies from Charcoal-Support
use Charcoal\Support\Property\ParsableValueTrait;

// Dependencies from Charcoal-City
use City\AbstractCityTemplate;

// Dependencies from `charcoal-cms`
use Charcoal\Cms\Support\Interfaces\SectionLoaderAwareInterface;
use Charcoal\Cms\Support\Traits\SectionLoaderAwareTrait;

/**
 * Abstract (base) template
 */
abstract class AbstractTemplate extends AbstractCityTemplate implements
    SectionLoaderAwareInterface,
    BreadcrumbAwareInterface
{
    use ParsableValueTrait;
    use SectionLoaderAwareTrait;
    use BreadcrumbAwareTrait;

    /**
     * @param Container $container Pimple/Container.
     * @return void
     */
    public function setDependencies(Container $container)
    {
        parent::setDependencies($container);

        $this->setSectionLoader($container['cms/section/loader']);
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
     * @return array
     */
    public function beforeBreadcrumb()
    {
        return [
            'label' => (string)$this->translator()->translation([
                'en' => 'Home',
                'fr' => 'Accueil'
            ]),
            'url'   => $this->baseUrl()
        ];
    }

    /**
     * @return string
     */
    abstract public function templateIdent();
}
