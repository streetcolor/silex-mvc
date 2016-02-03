<?php
namespace Component\DefaultBundle;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Default Controller Provider
 *
 * @package default
 */
class DefaultBundle implements
    ServiceProviderInterface,
    ControllerProviderInterface
{

    public function __construct(Application $app, $mount='/'){
        $app ->register($this);
        $app ->mount($mount, $this);
    }
    /**
     * Register services to the container
     *
     * @param  Application $app [description]
     * @return [type]           [description]
     */
    public function register(Application $app)
    {
        /*Mount all events here*/
        $events = [
                        new \Component\DefaultBundle\Services\EventServiceProvider
                    ];
        if(count($events)){
             $app->register(new \Core\InjectionEvent($events));
        }   
       
       /*Mount all services here*/
        $services = [
                        new \Component\DefaultBundle\Services\AcmeServiceProvider,
                    ];

        if(count($services)){
            $app->register(new \Core\InjectionService($services));    
        }

        $app['default.controller'] = $app->share(function() use ($app) {
            return new Controller\DefaultController($app);
        });
    }
    /**
     * Connect routes to their controllers
     *
     * @param  Application $app [description]
     * @return [type]           [description]
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers
            ->get('/', 'default.controller:getLogin')
            ->bind('default')
        ;

        $controllers
            ->get('/login', 'default.controller:getLogin')
            ->bind('default_login')
        ;

        $controllers
            ->get('/success', 'default.controller:getSuccess')
            ->bind('default_success')
        ;
        
        return $controllers;
    }

    public function boot(Application $app)
    {
    }
}