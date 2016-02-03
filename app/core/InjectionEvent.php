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
class InjectionEvent implements ServiceProviderInterface
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
        $app->before(function(Request $request, Application $app) {
            //echo "Before injector Event<hr>";
        });

        $app->after(function (Request $request, Response $response) {
            //echo "After injector Event <hr>";
        });
    }
}
