<?php

namespace City\ServiceProvider;

use City\Object\News;
use \Pimple\Container;
use \Pimple\ServiceProviderInterface;

// Module `charcoal-core` dependencies
use \Charcoal\Model\ModelLoader;

// From 'charcoal-factory'
use Charcoal\Factory\GenericFactory;

// From 'charcoal-cms'
use Charcoal\Cms\SectionInterface;

// Dependencies from 'charcoal-view'
use Charcoal\View\EngineInterface;
use Charcoal\View\Mustache\AssetsHelpers;

// Module `charcoal-search` dependencies
use \Charcoal\Search\SearchRunner;

// Dependencies from 'mcaskill/charcoal-support'
use Charcoal\Support\View\Mustache\GenericHelpers;
use Charcoal\Support\View\Mustache\DateTimeHelpers;
use Charcoal\Support\View\Mustache\StringHelpers;

use \city\Object\Section;
use \city\Object\AlertHelper;
use \city\Search\EventSearch;
use \city\Search\NewsSearch;
use \city\Search\DocumentSearch;
use \city\Search\SectionSearch;

/**
 * Saint-Constant Service Provider
 */
class CityServiceProvider implements ServiceProviderInterface
{

    /**
     * @param Container $container A pimple container instance.
     * @return void
     */
    public function register(Container $container)
    {
        /**
         * Enhance helpers for Mustache Engine
         *
         * @return MustacheEngine
         */
        $container->extend('view/engine/mustache', function (EngineInterface $engine, Container $container) {
            $generic  = new GenericHelpers();
            $datetime = new DateTimeHelpers();
            $string   = new StringHelpers();

            $generic->setDependencies($container);
            $datetime->setDependencies($container);

            $engine->mergeHelpers(
                $generic,
                $datetime,
                $string
            );

            return $engine;
        });

        /**
         * @param Container $container
         * @return ModelLoader
         */
        $container['city/news/loader'] = function (Container $container) {
            return new ModelLoader([
                'obj_type'  => 'city/object/news',
                'factory'   => $container['model/factory'],
                'cache'     => $container['cache']
            ]);
        };

        /**
         * @param Container $container
         * @return GenericFactory
         */
        $container['city/section/factory'] = function (Container $container) {
            return new GenericFactory([
                'base_class'       => SectionInterface::class,
                'arguments'        => $container['model/factory']->arguments(),
                'resolver_options' => [
                    'suffix' => 'Section'
                ]
            ]);
        };

        /**
         * @return ModelLoader
         */
        $container['city/section/loader'] = function (Container $container) {
            return new ModelLoader([
                'obj_type' => Section::class,
                'factory'  => $container['model/factory'],
                'cache'    => $container['cache']
            ]);
        };

        /**
         * @return ModelLoader
         */
        $container['city/event/loader'] = function (Container $container) {
            return new ModelLoader([
                'obj_type'  => 'city/object/event',
                'factory'   => $container['model/factory'],
                'cache'     => $container['cache']
            ]);
        };

        /**
         * @return ModelLoader
         */
        $container['city/text/loader'] = function (Container $container) {
            return new ModelLoader([
                'obj_type'  => 'city/object/text',
                'obj_key'   => 'ident',
                'factory'   => $container['model/factory'],
                'cache'     => $container['cache']
            ]);
        };

        /**
         * @return News alert
         */
        $container['city/alert/helper'] = function (Container $container) {
            return new AlertHelper([
                'factory'   => $container['model/factory'],
                'loader' => $container['model/collection/loader']
            ]);
        };

        /**
         * @return \Geocoder\Geocoder
         */
        $container['geocoder'] = function (Container $container) {
            $guzzleAdapter   = new \Ivory\HttpAdapter\Guzzle6HttpAdapter();

            $geocoder = new \Geocoder\ProviderAggregator();
            $geocoder->registerProvider(new \Geocoder\Provider\Chain([
                new \Geocoder\Provider\GoogleMaps($guzzleAdapter),
                new \Geocoder\Provider\ArcGISOnline($guzzleAdapter)
            ]));
            return $geocoder;
        };


        /**
         * @return EventSearch
         */
        $container['city/search/event'] = function (Container $container) {
            return new EventSearch([
                'logger' => $container['logger'],
                'modelFactory' => $container['model/factory']
            ]);
        };

        /**
         * @return NewsSearch
         */
        $container['city/search/news'] = function (Container $container) {
            return new NewsSearch([
                'logger' => $container['logger'],
                'modelFactory' => $container['model/factory']
            ]);
        };

        /**
         * @return DocumentSearch
         */
        $container['city/search/document'] = function (Container $container) {
            return new DocumentSearch([
                'logger' => $container['logger'],
                'modelFactory' => $container['model/factory']
            ]);
        };

        /**
         * @return SectionSearch
         */
        $container['city/search/section'] = function (Container $container) {
            return new SectionSearch([
                'logger' => $container['logger'],
                'modelFactory' => $container['model/factory']
            ]);
        };

        /**
         * @return SearchRunner
         */
        $container['city/search/runner'] = function (Container $container) {
            return new SearchRunner([
                'search_config' => [
                    'ident'         => 'city',
                    'searches'       => [
                        'sections'  => $container['city/search/section'],
                        'documents'  => $container['city/search/document'],
                        'news'      => $container['city/search/news'],
                        'events'    => $container['city/search/event']
                    ]
                ],
                'model_factory'     => $container['model/factory'],
                'logger'            => $container['logger']
            ]);
        };
    }
}
