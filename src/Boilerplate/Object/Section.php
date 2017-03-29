<?php

namespace Boilerplate\Object;

// Module `charcoal-attachment` dependencies
use Charcoal\Attachment\Traits\AttachmentAwareTrait;

// Module `charcoal-cms` dependencies
use Charcoal\Cms\AbstractSection;
use Charcoal\Cms\Mixin\HasContentBlocksInterface;
use Charcoal\Cms\Mixin\Traits\HasContentBlocksTrait;

// Dependencies from `mcaskill/charcoal-support`
use Charcoal\Support\Model\ManufacturableModelCollectionTrait;

// Dependencies from `pimple`
use Pimple\Container;

/**
 * Base section object
 * Section are the "pages" of the website
 */
class Section extends AbstractSection implements
    HasContentBlocksInterface
{
    use AttachmentAwareTrait;
    use ManufacturableModelCollectionTrait;
    use HasContentBlocksTrait;

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
