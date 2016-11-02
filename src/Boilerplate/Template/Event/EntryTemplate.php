<?php

namespace Boilerplate\Template\Event;

use Boilerplate\Object\Section;
use Charcoal\Model\ModelInterface;
use Boilerplate\Object\Event;

/**
 * Class EntryTemplate
 */
class EntryTemplate extends IndexTemplate
{
    /**
     * @var Section $parentSection The parent Section.
     */
    protected $parentSection;

    /**
     * @return string
     */
    public function templateIdent()
    {
        return 'event-entry';
    }

    /**
     * @return mixed
     */
    public function parentSection()
    {
        if ($this->parentSection) {
            return $this->parentSection;
        }

        $id                  = $this->sectionLoader()->resolveSectionId('/fr/evenements');
        $section             = $this->sectionLoader()->fromId($id);
        $this->parentSection = $section;

        return $this->parentSection;
    }

    // ==========================================================================
    // INIT
    // ==========================================================================

    /**
     * Set the current renderable object relative to the context.
     *
     * @param ModelInterface $context The context / view to render the template with.
     * @return self
     */
    public function setContextObject(ModelInterface $context)
    {
        if ($context instanceof Event) {
            $this->eventManager()->setCurrentEvent($context);
            $this->setSection($this->parentSection());
        }

        parent::setContextObject($context);

        return $this;
    }
}
