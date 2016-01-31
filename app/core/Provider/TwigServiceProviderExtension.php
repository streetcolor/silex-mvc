<?php

namespace Core\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Twig Service Provider extension.
 *
 * Register here any usefull global, filter,
 * tag...
 *
 * @package default
 */
class TwigServiceProviderExtension implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['twig.loader'] = $app->share(
            $app->extend(
                'twig.loader',
                function(\Twig_Loader_Chain $loader, Application $app) {
                    $loader->addLoader(new \Twig_Loader_Filesystem(APP_ROOT_PATH . '/views'));
                    $loader->addLoader(new \Twig_Loader_Filesystem(APP_ROOT_PATH . '/src'));
                    return $loader;
                }
            )
        );

        $app['twig'] = $app->share(
            $app->extend(
                'twig',
                function($twig, $app) {
                    // add extension filter etc
                    $twig->addGlobal('baseApiUrl', getenv('INTERNAL_API_URL'));

                    return $twig;
                }
            )
        );
    }

    public function boot(Application $app)
    {
    }
}
