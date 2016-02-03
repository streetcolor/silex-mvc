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
    	return  $this->app['twig']->render('DefaultBundle/View/index.html');
    }
}
