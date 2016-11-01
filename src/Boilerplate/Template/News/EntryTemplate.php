<?php

namespace Boilerplate\Template\News;

use Charcoal\Model\ModelInterface;
use Boilerplate\Object\News;

/**
 * Class EntryTemplate
 */
class EntryTemplate extends IndexTemplate
{
    /**
     * @return string
     */
    public function templateIdent()
    {
        return 'news-entry';
    }

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
        }

        parent::setContextObject($context);

        return $this;
    }
}
