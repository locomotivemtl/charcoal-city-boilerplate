<?php

/**
 * Application HTTP Middlewares
 *
 * @global \Charcoal\App\App $app The Charcoal application.
 */

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

// For managing translations from routes
use \McAskill\Slim\Polyglot\Polyglot;

use \Charcoal\App\App;
use \Charcoal\App\AppContainer;
use \Charcoal\App\Language\LanguageManager;

/** @var AppContainer $container The DI container used by the application. */
$container = $app->getContainer();

/** @var Language\LanguageManager The Charcoal application's language manager. */
// $language_manager = $app->languageManager()->setup();
$locales = $container['translator/locales'];

/**
 * Enable Multilingual Routes
 *
 * Polyglot detects the current language from the request and selects an available language.
 * That language is assigned to the Charcoal application's language manager.
 *
 * @see Polyglot For parsing languages in URIs
 */

$app->add(
    new Polyglot([
        'languages'                => $locales->languages(),
        'fallbackLanguage'         => $locales->defaultLanguage(),
        'callbacks'                => [
            [$locales, 'setCurrentLanguage'],
            [$container['translator/config'], 'setCurrentLanguage']
        ],
        'queryStringKeys'          => ['current_language'],
        'languageRequiredInUri'    => false,
        'languageIncludedInRoutes' => true,
    ])
);
