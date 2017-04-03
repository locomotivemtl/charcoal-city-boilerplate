<?php

namespace Boilerplate\Object;

// Local dependencies
use Boilerplate\Object\Event;
use Boilerplate\Object\News;

// dependencies from `charcoal-cms`
use Charcoal\Cms\Config as CmsConfig;

/**
 * Class Config
 */
class Config extends CmsConfig
{
    /**
     * Multiple
     * @var News
     */
    protected $homeNews;

    /** Multiple
     * @var Event
     */
    protected $homeEvents;

    /**
     * @var string $contactCategoryObj Must conform City\\Support\\Interface\\ContactCategoryInterface.
     */
    protected $contactCategoryObj;

    /**
     * @var string $defaultContactCategory The default contact category to fallback.
     */
    protected $defaultContactCategory;

    /**
     * @var string $contactObj Must conform City\\Support\\Interface\\ContactInterface.
     */
    protected $contactObj;

    // ==========================================================================
    // SETTERS
    // ==========================================================================

    /**
     * @param mixed $homeNews News to display on home page.
     * @return self.
     */
    public function setHomeNews($homeNews)
    {
        $this->homeNews = $homeNews;

        return $this;
    }

    /**
     * @param mixed $homeEvents Events to display on home page.
     * @return self.
     */
    public function setHomeEvents($homeEvents)
    {
        $this->homeEvents = $homeEvents;

        return $this;
    }

    /**
     * @param string $contactCategory Must conform City\\Support\\Interface\\ContactCategoryInterface.
     * @return self
     */
    public function setContactCategoryObj($contactCategory)
    {
        $this->contactCategoryObj = $contactCategory;

        return $this;
    }

    /**
     * @param string $contactObj Must conform City\\Support\\Interface\\ContactInterface.
     * @return self
     */
    public function setContactObj($contactObj)
    {
        $this->contactObj = $contactObj;

        return $this;
    }

    /**
     * @param string $defaultContactCategory The default contact category fallback.
     * @return self
     */
    public function setDefaultContactCategory($defaultContactCategory)
    {
        $this->defaultContactCategory = $defaultContactCategory;

        return $this;
    }

    // ==========================================================================
    // GETTERS
    // ==========================================================================

    /**
     * @return mixed
     */
    public function homeNews()
    {
        return $this->homeNews;
    }

    /**
     * @return mixed
     */
    public function homeEvents()
    {
        return $this->homeEvents;
    }

    /**
     * @return string
     */
    public function contactCategoryObj()
    {
        return $this->contactCategoryObj;
    }

    /**
     * @return string
     */
    public function contactObj()
    {
        return $this->contactObj;
    }

    /**
     * @return string
     */
    public function defaultContactCategory()
    {
        return $this->defaultContactCategory;
    }
}
