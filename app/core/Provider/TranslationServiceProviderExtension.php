<?php

namespace Core\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Translation\Loader\XliffFileLoader;

/**
 * Translation Service Provider extension.
 *
 * @package default
 */
class TranslationServiceProviderExtension implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
            $translator->addLoader('xliff', new XliffFileLoader());
            $translator->addResource('xliff', APP_ROOT_PATH . '/translation/en.xliff', 'en');
            $translator->addResource('xliff', APP_ROOT_PATH . '/translation/fr.xliff', 'fr');

            $translator->setLocale($app['session']->get('langue'));

            return $translator;
        }));
    }

    public function boot(Application $app)
    {
    }
}
