<?php
namespace Core;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Injection Service Provider extension.
 *
 * @package default
 */
class InjectionService implements ServiceProviderInterface
{	
	private $ervices = array();

	public function __construct($services){
		$this->services = $services;
	}

    public function register(Application $app)
    {
    	foreach ($this->services as $key => $service) {
    		$app->register($service);
    	}
    }

    public function boot(Application $app)
    {
    }
}
