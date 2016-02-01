<?php

namespace Component\DefaultBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Core\Controller;

/**
 * Deafault controller
 *
 * @package default
 */
class DefaultController extends Controller
{

    public function getIndex()
    {
    	$name =   $this->app['request']->get('name');

		$token = $this->app['security.token_storage']->getToken();
		if (null !== $token) {
		    $user = $token->getUser();
		}

		$encoder = $this->app['security.encoder_factory']->getEncoder($user);

		// compute the encoded password for sebastien
		$password = $encoder->encodePassword('sebastien', $user->getSalt());

		print_r($user->getRoles());


		echo $password;

    	return  $this->app['twig']->render('DefaultBundle/View/index.html', array(
	        'name' => $name,
	        'service' => $this->app['acme']
	    ));
    }

}
