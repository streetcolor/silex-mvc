<?php

namespace Component\KikiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Core\Controller;

/**
 * Deafault controller
 *
 * @package default
 */
class KikiController extends Controller
{

    public function getIndex()
    {
    	$name =   $this->app['request']->get('name');

    	return  $this->app['twig']->render('KikiBundle/View/index.html', array(
	        'name' => $name,
	        'service' => $this->app['acme.kiki']
	    ));
    }

}
