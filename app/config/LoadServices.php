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
        * @note Please to define user.provider 
        * @doc http://silex.sensiolabs.org/doc/providers/security.html
        */
        $this->app->register(new SecurityServiceProvider(), array(
            'security.firewalls' => array(
                'secured' => array(
                    'pattern' => '^.*$',
                    'anonymous' => true, // Indispensable car la zone de login se trouve dans la zone sécurisée (tout le front-office)
                    'form' => array(
                            'login_path' => $this->app['user.login_path'], 
                            'check_path' => 'connexion',
                            'default_target_path' => $this->app['user.default_target_path']),
                    'logout' => array('logout_path' => $this->app['user.logout_path']), // url à appeler pour se déconnecter
                    'users' =>  $this->app['user.provider'],
                ),
            ),
            'security.access_rules' => array(
                // ROLE_USER est défini arbitrairement, vous pouvez le remplacer par le nom que vous voulez
                array('^/user/success', 'ROLE_USER'),
                array('^/foo$', ''), // Cette url est accessible en mode non connecté
            )
    
        ));


    }
}