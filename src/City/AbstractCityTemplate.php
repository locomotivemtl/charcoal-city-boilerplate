<?php

namespace City;

use \Pimple\Container;

// Dependency from 'charcoal-config'
use \Charcoal\Config\ConfigInterface;

// Dependency from 'charcoal-app'
use \Charcoal\App\Template\AbstractTemplate;

/**
 * Base class for all "City" templates.
 */
abstract class AbstractCityTemplate extends AbstractTemplate
{
    /**
     * @var ConfigInterface $translationConfig
     */
    private $translationConfig;

    /**
     * @param Container $container The pimple DI container.
     * @return void
     */
    public function setDependencies(Container $container)
    {
        parent::setDependencies($container);

        $this->setTranslationConfig($container['translator/config']);
    }

    /**
     * @param ConfigInterface $config The translaction config object (translator).
     * @return CityTemplate Chainable
     */
    private function setTranslationConfig(ConfigInterface $config)
    {
        $this->translationConfig = $config;

        return $this;
    }

    /**
     * @return ConfigInterface
     */
    protected function translationConfig()
    {
        return $this->translationConfig;
    }

    /**
     * Get the current language code.
     *
     * @return string
     */
    public function lang()
    {
        return $this->translationConfig()->currentLanguage();
    }

    /**
     * @return string
     */
    public function pageTitle()
    {
        return 'Charcoal Project City';
    }
}
