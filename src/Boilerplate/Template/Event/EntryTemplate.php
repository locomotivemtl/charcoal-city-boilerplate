<?php

namespace Boilerplate\Template\Event;

// Module `charcoal-core` dependencies
use Charcoal\Model\ModelInterface;

// Local module dependencies
use Boilerplate\Object\Event;

/**
 * Event entry template
 */
class EntryTemplate extends IndexTemplate
{
    /**
     * @return string
     */
    public function templateIdent()
    {
        return 'event-entry';
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
            $this->setSection($this->sectionFromSlug('/fr/evenements'));
        }

        parent::setContextObject($context);

        return $this;
    }
}
