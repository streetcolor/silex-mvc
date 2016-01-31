<?php

namespace Component\DefaultBundle\Services;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Acme Service Provider.
 *
 * @package default
 */
class AcmeServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['acme'] = $app->share(function() use ($app) {
            return array('acme'=>"hello");
        });
    }

    public function boot(Application $app)
    {
    
    }
}
