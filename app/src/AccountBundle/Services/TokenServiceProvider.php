<?php

namespace Src\AccountBundle\Services;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Acme Service Provider.
 *
 * @package Account
 */
class TokenServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['token.user'] = $app->share(function() use ($app) {

			$username =  $app['security.token_storage']->getToken()->getUser()->getUsername(); 
			$user  = $app['orm.em']->getRepository('\Entities\User')->findOneBy(array('username' => $username));

            return $user;
        });
    }

    public function boot(Application $app)
    {
    
    }
}
