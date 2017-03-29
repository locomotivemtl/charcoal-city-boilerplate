<?php

namespace Boilerplate\Object;

// Dependencies from `charcoal-cms` module
use Charcoal\Attachment\Interfaces\AttachmentAwareInterface;
use Charcoal\Attachment\Traits\AttachmentAwareTrait;
use Charcoal\Cms\AbstractNews;
use Charcoal\Cms\Mixin\HasContentBlocksInterface;
use Charcoal\Cms\Mixin\Traits\HasContentBlocksTrait;
use Charcoal\Cms\NewsCategory;
use Charcoal\Object\CategoryInterface;
use Charcoal\Support\Model\ManufacturableModelCollectionTrait;
use Pimple\Container;

/**
 * News model
 */
class News extends AbstractNews implements
    AttachmentAwareInterface,
    HasContentBlocksInterface
{
    use AttachmentAwareTrait;
    use ManufacturableModelCollectionTrait;
    use HasContentBlocksTrait;

    /**
     * Boolean param to set news as alert.
     * @var boolean $alert
     */
    protected $alert;

    /**
     * @var CategoryInterface
     */
    protected $categoryObj;

    // ==========================================================================
    // INIT
    // ==========================================================================

    /**
     * Section constructor.
     * @param array $data The data.
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);

        if (is_callable([$this, 'defaultData'])) {
            $this->setData($this->defaultData());
        }
    }

    /**
     * @param Container $container Pimple/Container.
     * @return void
     */
    public function setDependencies(Container $container)
    {
        parent::setDependencies($container);

        $this->setCollectionLoader($container['model/collection/loader']);
    }

    /**
     * Defines the mustache template for the view.
     *
     * @return string
     */
    public function templateIdent()
    {
        return 'boilerplate/template/news/entry';
    }

    // ==========================================================================
    // FUNCTIONS
    // ==========================================================================

    /**
     * @return mixed
     */
    public function categoryObj()
    {
        if ($this->categoryObj) {
            return $this->categoryObj;
        }

        $this->categoryObj = $this->modelFactory()->create(NewsCategory::class);

        if ($this->category()) {
            $this->categoryObj->load($this->category());
        }

        return $this->categoryObj;
    }

    /**
     * @return string
     */
    public function categoryName()
    {
        if ($this->categoryObj() && $this->categoryObj()->id()) {
            return (string)$this->categoryObj()->name();
        }

        return '';
    }

    // ==========================================================================
    // SETTERS
    // ==========================================================================

    /**
     * @param boolean $alert Alert.
     * @return $this
     */
    public function setAlert($alert)
    {
        $this->alert = !!$alert;

        return $this;
    }

    // ==========================================================================
    // GETTERS
    // ==========================================================================

    /**
     * @return boolean
     */
    public function alert()
    {
        return $this->alert;
    }

    // ==========================================================================
    // EVENTS
    // ==========================================================================

    /**
     * Remove unnecessary joins.
     * @return boolean Parent preDelete().
     */
    public function preDelete()
    {
        // AttachmentAwareTrait
        $this->removeJoins();

        return parent::preDelete();
    }
}
