<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Controller\SalleController;
use App\Repository\EloquentSalleRepository;
use App\Validation\SalleValidator;
use App\View\View;
use Dotenv\Dotenv;

Dotenv::createImmutable(dirname(__DIR__))->load();
(require dirname(__DIR__) . '/config/database.php')();

$controller = new SalleController(
    new EloquentSalleRepository(),
    new SalleValidator(),
    new View(dirname(__DIR__) . '/templates')
);

echo $controller->index();