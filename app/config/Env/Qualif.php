<?php

namespace config\Env;

use Silex\Application;
use Silex\Provider\WebProfilerServiceProvider;
use config\LoadServices;

/**
 * QUALIFICATION specific configuration class
 *
 * We register here all the required Providers.
 * DO NOT extend or register simple services here,
 * create instead a Service Provider and register it here.
 *
 */
class Qualif extends LoadServices
{
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    public function register()
    {
    }
}
