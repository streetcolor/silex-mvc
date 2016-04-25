<?php
namespace Src\UserBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Silex\ServiceProviderInterface;
use Silex\Application;

/**
 * Acme Service Provider.
 *
 * @package default
 */
class EventServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {

    }

    public function boot(Application $app)
    {
        $app->before(function(Request $request, Application $app) {
            
            /**
            * Validator constraint
            *
            * @note Overload constraints validator
            * @doc http://silex.sensiolabs.org/doc/providers/validator.html
             */
            $app['validator.validator_service_ids'] =  isset($app['validator.validator_service_ids']) ? $app['validator.validator_service_ids'] : array();
            $app['validator.validator_service_ids'] = array_merge(
            $app['validator.validator_service_ids'],
                array('validator.uniqueUser' => 'validator.constraint.uniqueUser')
            );

        });

        $app->after(function (Request $request, Response $response) {
            //echo "After Service Event <hr>";
        });
    }
}