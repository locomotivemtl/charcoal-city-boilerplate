<?php

namespace Boilerplate\Object;

// Module `charcoal-attachment` dependencies
use Charcoal\Attachment\Interfaces\AttachmentAwareInterface;
use Charcoal\Attachment\Traits\AttachmentAwareTrait;

// Module `charcoal-cms` dependencies
use Charcoal\Cms\AbstractSection;

// Dependencies from `mcaskill/charcoal-support`
use Charcoal\Support\Model\ManufacturableModelCollectionTrait;

// Dependencies from `pimple`
use Pimple\Container;

/**
 * Base section object
 * Section are the "pages" of the website
 */
class Section extends AbstractSection implements
    AttachmentAwareInterface
{
    use AttachmentAwareTrait;
    use ManufacturableModelCollectionTrait;

    // ==========================================================================
    // INIT
    // ==========================================================================

    /**
     * Inject dependencies from a DI Container.
     *
     * @param  Container $container A dependencies container instance.
     * @return void
     */
    public function setDependencies(Container $container)
    {
        parent::setDependencies($container);

        $this->setCollectionLoader($container['model/collection/loader']);
    }
}
