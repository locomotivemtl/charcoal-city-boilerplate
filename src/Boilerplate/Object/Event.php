<?php

namespace Boilerplate\Object;

// Dependencies from `charcoal-cms` module
use Charcoal\Attachment\Interfaces\AttachmentAwareInterface;
use Charcoal\Attachment\Traits\AttachmentAwareTrait;
use Charcoal\Cms\AbstractEvent;
use Charcoal\Cms\EventCategory;
use Charcoal\Cms\Mixin\HasContentBlocksInterface;
use Charcoal\Cms\Mixin\Traits\HasContentBlocksTrait;
use Charcoal\Object\CategoryInterface;
use Charcoal\Support\Model\ManufacturableModelCollectionTrait;
use Charcoal\Translator\Translation;
use Pimple\Container;

/**
 * Event model
 */
class Event extends AbstractEvent implements
    AttachmentAwareInterface,
    HasContentBlocksInterface
{
    use AttachmentAwareTrait;
    use ManufacturableModelCollectionTrait;
    use HasContentBlocksTrait;

    /**
     * @var Translation|string $locationName
     */
    protected $locationName;

    /**
     * @var integer $category
     */
    protected $category;

    /**
     * @var CategoryInterface $categoryObj
     */
    protected $categoryObj;

    /**
     * @var string $postalCode
     */
    protected $postalCode;

    /**
     * @var string $address
     */
    protected $address;

    /**
     * @var Translation|string $state
     */
    protected $state;

    /**
     * @var Translation|string $country
     */
    protected $country;

    /**
     * @var Translation|string $city
     */
    protected $city;

    /**
     * @var Translation|string $externalUrl
     */
    protected $externalUrl;

    /**
     * @var boolean $displayHours Whether to display the time or not.
     */
    protected $displayHours;

    /**
     * @var Translation|string $dateNotes Custom date notes to replace time.
     */
    protected $dateNotes;

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

        $this->setCollectionLoader($container['model/collection/loader']);
    }

    /**
     * Defines the mustache template for the view.
     *
     * @return string
     */
    public function templateIdent()
    {
        return 'boilerplate/template/event-details';
    }

    // ==========================================================================
    // FUNCTIONS
    // ==========================================================================

    /**
     * @return string
     */
    public function categoryName()
    {
        if (!$this->category()) {
            return '';
        }

        if (!$this->categoryObj()) {
            return '';
        }

        return $this->categoryObj()->name();
    }

    /**
     * @return mixed
     */
    public function categoryObj()
    {
        if ($this->categoryObj) {
            return $this->categoryObj;
        }

        if (!$this->category()) {
            return false;
        }

        $this->categoryObj = $this->modelFactory()->create(EventCategory::class)->load($this->category());

        return $this->categoryObj;
    }

    // ==========================================================================
    // SETTERS
    // ==========================================================================

    /**
     * @param Translation|string $name The location name.
     * @return self
     */
    public function setLocationName($name)
    {
        $this->locationName = $this->translator()->translation($name);

        return $this;
    }

    /**
     * @param mixed $cat The event category.
     * @return self
     */
    public function setCategory($cat)
    {
        $this->category = $cat;

        return $this;
    }

    /**
     * @param Translation|string $address The event street address.
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $this->translator()->translation($address);

        return $this;
    }

    /**
     * @param Translation|string $city The event's city.
     * @return self
     */
    public function setCity($city)
    {
        $this->city = $this->translator()->translation($city);

        return $this;
    }

    /**
     * @param Translation|string $state The event's state.
     * @return self
     */
    public function setState($state)
    {
        $this->state = $this->translator()->translation($state);

        return $this;
    }

    /**
     * @param Translation|string $country The event's country.
     * @return self
     */
    public function setCountry($country)
    {
        $this->country = $this->translator()->translation($country);

        return $this;
    }

    /**
     * @param string $postalCode The event postal code.
     * @return self
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @param Translation|string $url The event's website url.
     * @return self
     */
    public function setExternalUrl($url)
    {
        $this->externalUrl = $this->translator()->translation($url);

        return $this;
    }

    /**
     * @param boolean $displayHours Whether the time is to be displayed.
     * @return self
     */
    public function setDisplayHours($displayHours)
    {
        $this->displayHours = $displayHours;

        return $this;
    }

    /**
     * @param mixed $dateNotes Replace the time with a custom one.
     * @return self
     */
    public function setDateNotes($dateNotes)
    {
        $this->dateNotes = $this->translator()->translation($dateNotes);

        return $this;
    }

    // ==========================================================================
    // GETTERS
    // ==========================================================================

    /**
     * @return mixed
     */
    public function locationName()
    {
        return $this->locationName;
    }

    /**
     * @return mixed
     */
    public function category()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function address()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function city()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function state()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function country()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function postalCode()
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function externalUrl()
    {
        return $this->externalUrl;
    }

    /**
     * @return boolean
     */
    public function displayHours()
    {
        return $this->displayHours;
    }

    /**
     * @return string
     */
    public function dateNotes()
    {
        return $this->dateNotes;
    }

    // ==========================================================================
    // EVENTS
    // ==========================================================================

    /**
     * Remove unnecessary joins.
     * @return boolean parent preDelete().
     */
    public function preDelete()
    {
        // AttachmentAwareTrait
        $this->removeJoins();

        return parent::preDelete();
    }
}
