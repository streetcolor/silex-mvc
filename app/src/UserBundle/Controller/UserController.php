<?php

namespace Component\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Core\Controller;

/**
 * Deafault controller
 *
 * @package default
 */
class UserController extends Controller
{

    public function getIndex()
    {
    	return  $this->app['twig']->render('UserBundle/View/account.html');
    }

    public function getLogin()
    {

        //$encoder = $this->app['security.encoder_factory']->getEncoder($user);
        // compute the encoded password for sebastien
        //$password = $encoder->encodePassword('sebastien', $user->getSalt());
        //print_r($user->getRoles());
        //echo $password.' '.$user->getUsername();


        $user = "";
        $token = $this->app['security.token_storage']->getToken();

        if($this->app['security.authorization_checker']->isGranted('ROLE_USER')){
            if (null !== $token) {
                $user = $token->getUser()->getUsername();
            }
        }
    	return  $this->app['twig']->render('UserBundle/View/login.html', array(
            'username'      => $user,
			'error'         => $this->app['security.last_error']($this->request),
			'last_username' => $this->app['session']->get('_security.last_username'),
	    ));
    }

    public function getSuccess(){
        
        $token = $this->app['security.token_storage']->getToken();


        return  $this->app['twig']->render('UserBundle/View/account.html', array(
            'username'      => $token->getUser()->getUsername()
        ));


    }

}
