<?php

namespace Src\UserBundle\Services;

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
class UserConstraintServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        
        $app['validator.constraint.uniqueUser'] = $app->share(function($app) {
            return new \Src\UserBundle\Validation\Constraints\UniqueUserValidator($app['orm.em'], 'test');
        });
        /*
        * Voucher validator
        * @note: uses ValidatorServiceProvider
        */
        $app['user.validator'] = $app->share(function() use ($app) {
            return new \Src\UserBundle\Validation\UserValidator($app['validator']);
        });

        

    }


    public function boot(Application $app)
    {
    
    }


}
