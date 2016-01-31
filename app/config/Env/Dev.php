<?php

namespace config\Env;

use Silex\Application;
use Silex\Provider\WebProfilerServiceProvider;
use Silex\Provider\MonologServiceProvider;
use config\LoadServices;

/**
 * DEVELOPMENT specific configuration class
 *
 * We register here all the required Providers.
 * DO NOT extend or register simple services here,
 * create instead a Service Provider and register it here.
 *
 */
class Dev extends LoadServices
{
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    public function register()
    {
        $this->app['debug'] = true;

        /**
         * Web profiler
         *
         * @note Silex native
         * @doc https://github.com/silexphp/Silex-WebProfiler
         */
        $this->app->register(new WebProfilerServiceProvider(), array(
            'profiler.cache_dir' => 'var/cache/profiler',
        ));

        /**
         * Monolog
         *
         * @note Silex Native
         * + we MUST use symfony http-kernel 2.8 in order to make
         * this provider work.
         * @doc http://silex.sensiolabs.org/doc/providers/monolog.html
         * @see https://github.com/silexphp/Silex-Skeleton/issues/60
         */
        $this->app->register(new \Silex\Provider\MonologServiceProvider(), array(
            'monolog.logfile' => 'var/logs/silex_dev.log',
        ));
    }
}