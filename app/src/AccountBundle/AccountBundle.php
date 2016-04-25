<?php
namespace Src\AccountBundle;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Account Controller Provider
 *
 * @package account
 */
class AccountBundle implements
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
                        new \Src\AccountBundle\Services\EventServiceProvider
                    ];
        if(count($events)){
             $app->register(new \Core\InjectionEvent($events));
        }   
       
       /*Mount all services here*/
        $services = [
                        new \Src\AccountBundle\Services\OrmServiceProvider,
                        new \Src\AccountBundle\Services\TokenServiceProvider,
                        new \Src\AccountBundle\Services\AccountConstraintServiceProvider
                    ];

        if(count($services)){
            $app->register(new \Core\InjectionService($services));    
        }

        $app['account.controller'] = $app->share(function() use ($app) {
            return new Controller\AccountController($app);
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
            ->get('/', 'account.controller:getIndex')
            ->bind('account')
        ;

        $controllers
            ->get('/medicines', 'account.controller:ajaxGetMedicines')
            ->bind('ajax_get_medicine')
        ;
        
        $controllers
            ->post('/medicines', 'account.controller:ajaxPostMedicines')
            ->bind('ajax_post_medicine')
        ;

         $controllers
            ->delete('/medicines', 'account.controller:ajaxDeleteMedicines')
            ->bind('ajax_delete_medicine')
        ;
        
        $controllers
            ->put('/users/medicines/{id}', 'account.controller:ajaxPutUserMedicines')
            ->bind('ajax_put_user_medicine')
            ->assert('id', '\d+');
        ;

        $controllers
            ->get('/users/medicines/{id}', 'account.controller:ajaxGetUserMedicines')
            ->bind('ajax_get_user_medicine')
            ->assert('id', '\d+');
        ;

        
        return $controllers;
    }

    public function boot(Application $app)
    {
    }
}