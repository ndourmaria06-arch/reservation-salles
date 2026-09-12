<?php

declare(strict_types=1);

use App\Application;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

require dirname(__DIR__) . '/vendor/autoload.php';

Dotenv::createImmutable(dirname(__DIR__))->safeLoad();

$builder = new ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__) . '/config/container.php');
$container = $builder->build();

// Force la construction de la connexion Eloquent avant tout le reste
$container->get(Capsule::class);

$application = $container->get(Application::class);
$application->run();