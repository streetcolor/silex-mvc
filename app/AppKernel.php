<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
/**
 * Application class
 *
 * @package default
 */
class AppKernel extends Application
{

    protected static $envMap = [
        'dev' => 'config\\Env\\Dev',
        'qualif' => 'config\\Env\\Qualif',
        'prod' => 'config\\Env\\Prod'
    ];

    public static $app;

    public function __construct()
    {
        parent::__construct();
        $this->registerBundles();
        $this->configure();
        $this->mountRoutes();
        $this->exception();
        
    }

    /**
     * Configure the application
     * based on the current environment
     *
     * @return type
     */
    protected function configure()
    {
        $env = getenv('ENV');
        if (isset(self::$envMap[strtolower($env)])) {
            $class = self::$envMap[strtolower($env)];
            $config = new $class($this);
            $config->register();
        }
    }

    /**
     * Mounts given patterns to specific
     * Controller Service
     *
     * @return type
     */
    protected function mountRoutes()
    {
       
        // Error handling
        $app = $this;
        $this->error(function (\Exception $e, $code) use ($app) {
            if ($app['debug']) {
                return;
            }

            // 404.html, or 40x.html, or 4xx.html, or error.html
            $templates = array(
                'errors/'.$code.'.html',
                'errors/'.substr($code, 0, 2).'x.html',
                'errors/'.substr($code, 0, 1).'xx.html',
                'errors/default.html',
            );

            return new Response(
                $app['twig']->resolveTemplate($templates)->render(['code' => $code]),
                $code
            );
        });
    }

    protected function exception()
    {
         $app = $this;
        $app->error(function(\Doctrine\DBAL\DBALException $e, $code) use ($app) {

            switch ($e->getErrorCode()) {
               
                case 1062:
                    $message = 'This entry already exist';
                    break;

                default:
                    $message = 'An MySql error has occured';
                    break;
            }

            return $app->json([
                'status' => 'error',
                'code' => $code,
                'error_sql_code'=>$e->getErrorCode(),
                'error_sql_message'=>$message,
                'message'=>$e->getMessage()
            ]);
        });

    }
    private function registerBundles(){
        
        new Src\HomeBundle\HomeBundle($this, '/');
        new Src\UserBundle\UserBundle($this, '/user');
        new Src\AccountBundle\AccountBundle($this, '/account');

    }
}