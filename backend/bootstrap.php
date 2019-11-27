<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Entity"), true);

$conn = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '123456',
    'dbname'   => 'merp',
);


$entityManager = EntityManager::create($conn, $config);