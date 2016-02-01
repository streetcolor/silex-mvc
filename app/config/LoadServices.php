<?php

namespace config;

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SecurityServiceProvider;

/**
 * Base Config class.
 *
 * ALL environment specific classes MUST
 * inherit this base class.
 *
 * @see Core\Config\Env\*
 * @package default
 */
class LoadServices
{
    /** @var Application our application */
    protected $app;

    /**
     * Constructor
     *
     * @param Application $app [description]
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        self::register();
    }

    /**
     * Register base config providers
     *
     * @return [type] [description]
     */
    protected function register()
    {
        /**
         * Controllers As a Service
         *
         * @note Silex Native
         * @doc http://silex.sensiolabs.org/doc/providers/service_controller.html
         */
        $this->app->register(new ServiceControllerServiceProvider());

        /**
         * Doctrine DBAL
         *
         * @note Silex Native
         * @doc http://silex.sensiolabs.org/doc/providers/doctrine.html
         */
        $this->app->register(new DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver' => 'pdo_mysql',
                'host' => getenv('DBHOST'),
                'dbname' => getenv('DBNAME'),
                'user' => getenv('DBUSER'),
                'password' => getenv('DBPASS'),
                'charset' => 'utf8'
            ),
        ));

        /**
         * Session
         *
         * @note Silex Native
         * @doc http://silex.sensiolabs.org/doc/providers/session.html
         */
        $this->app->register(new SessionServiceProvider());
        
        /**
         * Url Generator
         *
         * @note Silex Native
         * @doc http://silex.sensiolabs.org/doc/providers/url_generator.html
         */
        $this->app->register(new UrlGeneratorServiceProvider());

        /**
         * Form + validation
         *
         * @note Silex Native
         * @doc http://silex.sensiolabs.org/doc/providers/validator.html
         */
        $this->app->register(new ValidatorServiceProvider());

        /**
         * Twig
         *
         * @note Silex Native
         * @doc http://silex.sensiolabs.org/doc/providers/twig.html
         */
        $this->app->register(new TwigServiceProvider(array(
            'twig.options' => [
                'cache' => APP_ROOT_PATH . '/cache/twig'
            ]
        )));

        /**
         * Twig Extension
         *
         * @note Custom Provider
         * @doc todo
         */
        $this->app->register(new \Core\Provider\TwigServiceProviderExtension());

        /**
        * Translation
        *
        * @note Silex Native
        * @doc http://silex.sensiolabs.org/doc/providers/translation.html
        */
        $this->app->register(new TranslationServiceProvider(), array(
            'locale_fallbacks' => array('fr')
        ));

        /**
        * Translation Extension
        *
        * @note Custom Provider
        * @doc todo
        */
        $this->app->register(new \Core\Provider\TranslationServiceProviderExtension());

        /**
        * Fragment Provider
        *
        * @note Silex Native
        * @doc http://silex.sensiolabs.org/doc/providers/http_fragment.html
        */
        $this->app->register(new HttpFragmentServiceProvider());

        /**
        * Security Provider
        *
        * @note Silex Native
        * @doc http://silex.sensiolabs.org/doc/providers/security.html
        */
        $this->app->register(new SecurityServiceProvider(), array(
            'security.firewalls'=>array(
                'sebastien' => array(
                    'pattern' => '^/test',
                    'http' => true,
                    'users' => $this->app->share(function () {
                       return new \config\UserProvider();
                    }),
                ),
            )
        ));


    }
}