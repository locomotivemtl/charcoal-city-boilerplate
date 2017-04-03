<?php

namespace Boilerplate\Template;

// Module `charcoal-core` dependencies
use Charcoal\Model\ModelInterface;

use Boilerplate\Object\News;

/**
 * News entry template
 */
class NewsDetailsTemplate extends NewsListTemplate
{
    /**
     * @return string
     */
    public function templateIdent()
    {
        return 'news-entry';
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
        if ($context instanceof News) {
            $this->newsManager()->setCurrentNews($context);
            $this->setSection($this->sectionFromSlug('/fr/actualite'));
        }

        parent::setContextObject($context);

        return $this;
    }
}
