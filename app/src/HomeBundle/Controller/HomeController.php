<?php

namespace Src\HomeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Core\Controller;

/**
 * Home controller
 *
 * @package default
 */
class HomeController extends Controller
{

    public function getIndex()
    {
    	return  $this->app['twig']->render('HomeBundle/View/index.twig');
    }


    public function getContact()
    {
    	return  $this->app['twig']->render('HomeBundle/View/contact.twig');
    }
}
