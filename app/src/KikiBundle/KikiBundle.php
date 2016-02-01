<?php
namespace Component\KikiBundle;

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
class KikiBundle implements
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
        /*Mount all services here*/

        $services = [
                        new \Component\KikiBundle\Services\AcmeServiceProvider,
                    ];

        $app->register(new \Core\InjectionService($services));

        $app['kiki.controller'] = $app->share(function() use ($app) {
            return new Controller\KikiController($app);
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
            ->get('/{name}', 'kiki.controller:getIndex')
            ->bind('kiki_index')
        ;
        
        return $controllers;
    }

    public function boot(Application $app)
    {
    }
}