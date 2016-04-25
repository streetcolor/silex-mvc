#!/usr/bin/env php5
<?php
// Load your bootstrap or instantiate application and setup your config here
 if (!defined('APP_ROOT')) {
    define('APP_ROOT', '/Users/streetcolor/Sites/silex-mvc/');
}


require_once APP_ROOT .'/vendor/autoload.php';


$app        = new Silex\Application();
 
// Doctrine DBAL
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'host' => '127.0.0.1',
        'dbname' => 'GWT',
        'user' => 'streetcolor',
        'password' => 'viveinternet9452',
        'charset' => 'utf8'
    ),
));

 
// Doctrine ORM, I like the defaults, so I've only modified the proxies dir and entities path / namespace
$app->register(new Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider(), array(
    'orm.proxies_dir'           => __DIR__ . '/cache/doctrine/proxy',
    'orm.em.options' => array(
        'mappings' => array(
            // Using actual filesystem paths
            array(
                'type' => 'annotation',
                'namespace' => 'Entities',
                'path' => '/Users/streetcolor/Sites/silex-mvc/app/Entities',
            ),
        ),
    ),
));

 
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Helper\HelperSet;
 
$helperSet = new HelperSet(array(
    'db' => new ConnectionHelper($app['orm.em']->getConnection()),
    'em' => new EntityManagerHelper($app['orm.em'])
));
 
 /*
@notice  php UserBundle/console.php orm:generate-entities UserBundle/
@notice php vouchers/console.php orm:schema-tool:update
 */
ConsoleRunner::run($helperSet);