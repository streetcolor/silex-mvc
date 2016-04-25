<?php
namespace Src\UserBundle;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Validator\Validation;
use Silex\Provider\ValidatorServiceProvider;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Default Controller Provider
 *
 * @package default
 */
class UserBundle implements
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
                        new \Src\UserBundle\Services\EventServiceProvider
                    ];
        if(count($events)){
             $app->register(new \Core\InjectionEvent($events));
        }   
       
       /*Mount all services here*/
        $services = [
                        new \Src\UserBundle\Services\OrmServiceProvider,
                        new \Src\UserBundle\Services\UserServiceProvider,
                        new \Src\UserBundle\Services\UserConstraintServiceProvider
                    ];

        if(count($services)){
            $app->register(new \Core\InjectionService($services));    
        }

        $app['user.controller'] = $app->share(function() use ($app) {
            return new Controller\UserController($app);
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
            ->get('/sign-up', 'user.controller:getSignUp')
            ->bind('user_signup')
        ;

        $controllers
            ->post('/sign-up', 'user.controller:getSignUp')
            ->bind('user_signup_post')
        ;
    
        return $controllers;
    }

    public function boot(Application $app)
    {
    }
}