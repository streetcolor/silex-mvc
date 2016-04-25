<?php

namespace Src\AccountBundle\Services;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Doctrine\DBAL\Connection;

/**
 * Acme Service Provider.
 *
 * @package default
 */
class AccountConstraintServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        
        /*
        * Account validator
        * @note: uses ValidatorServiceProvider
        */
        $app['account.validator'] = $app->share(function() use ($app) {
            return new \Src\AccountBundle\Validation\AccountValidator($app['validator']);
        });

        

    }


    public function boot(Application $app)
    {
    
    }


}
