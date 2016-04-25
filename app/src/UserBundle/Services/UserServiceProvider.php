<?php

namespace Src\UserBundle\Services;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * Acme Service Provider.
 *
 * @package default
 */
class UserServiceProvider implements ServiceProviderInterface, UserProviderInterface
{   

    private $em;


    public function register(Application $app)
    {

        $app['service.security'] = $app->share(function() use ($app) {
            return array(
                'security.firewalls' => array(
                    'secured' => array(
                        'pattern' => '^.*$',
                        'anonymous' => true, // Indispensable car la zone de login se trouve dans la zone sécurisée (tout le front-office)
                        'form' => array(
                                'login_path' => '/user/sign-up', 
                                'check_path' => 'connexion',
                                'default_target_path' => '/account'),
                        'logout' => array('logout_path' => '/deconnexion'), // url à appeler pour se déconnecter
                        'users' =>  $this,
                        'remember_me' => array(
                            'key'                => 'Choose_A_Unique_Random_Key',
                            'always_remember_me' => false,
                            /* Other options */
                        ),
                    ),
                ),
                'security.access_rules' => array(
                    // ROLE_USER est défini arbitrairement, vous pouvez le remplacer par le nom que vous voulez
                    array('^/account', 'ROLE_USER'),
                )
        
            );
     });
    

    }

    public function loadUserByUsername($username)
    {
        $getUser = $this->em->getRepository('\Entities\User')->findOneBy(array('username'=>$username));
        if($getUser){
           return   new User($getUser->getUsername(), $getUser->getPassword(), explode(',', 'ROLE_USER'), true, true, true, true);
        }

         throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );

    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }


    public function boot(Application $app)
    {

        $this->em = $app['orm.em'];
         
    }


}
