<?php

namespace Src\AccountBundle\Services;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Acme Service Provider.
 *
 * @package Account
 */
class OrmServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {

        $entities =  isset($app['orm.em.options.mappings.entities']) ? $app['orm.em.options.mappings.entities'] : []; 

        $entities[] = array(
            'type' => 'annotation',
            'namespace' => 'Entities',
            'path' => __DIR__.'/Entities',
        );

         $app['orm.em.options.mappings.entities']  = $entities;
        
    }

    public function boot(Application $app)
    {
    
    }
}
