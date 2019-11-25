<?php
namespace App;

use DI\ContainerBuilder;
use Interop\Container\ContainerInterface;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class App extends \DI\Bridge\Slim\App {
    

    protected function configureContainer(ContainerBuilder $builder){

        $paths = array(__DIR__."/Entity");
        $isDevMode = false;

        // the connection configuration
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'user'     => 'root',
            'password' => '123456',
            'dbname'   => 'merp2',
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $definitions = [
            'settings.displayErrorDetails' => true,
            EntityManager::class => function() {
                $dbParams = array(
                    'driver'   => 'pdo_mysql',
                    'user'     => 'root',
                    'password' => '123456',
                    'dbname'   => 'merp2',
                );
                $paths = array(__DIR__."/Entity");
                $isDevMode = true;
                $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
                return EntityManager::create($dbParams, $config);
            }
        ];

        $builder->addDefinitions($definitions);
    }
}
