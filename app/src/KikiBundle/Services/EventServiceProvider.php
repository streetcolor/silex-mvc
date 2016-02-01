<?php
namespace Component\KikiBundle\Services;

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
            echo "Before Service Kiki Event<hr>";
        });

        $app->after(function (Request $request, Response $response) {
            echo "After Service Kiki Event <hr>";
        });
    }
}