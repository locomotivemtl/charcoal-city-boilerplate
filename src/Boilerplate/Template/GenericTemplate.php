<?php

namespace Boilerplate\Template;

// Local module dependencies
use Boilerplate\Template\AbstractTemplate;

/**
 * Generic template (fallback template)
 */
class GenericTemplate extends AbstractTemplate
{
    /**
     * @return string
     */
    public function templateIdent()
    {
        return 'generic';
    }
}
