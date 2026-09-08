<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Controller\SalleController;
use App\Repository\EloquentSalleRepository;
use App\Validation\SalleValidator;
use App\View\View;
use Dotenv\Dotenv;

Dotenv::createImmutable(__DIR__ . '/..')->load();
(require __DIR__ . '/../config/database.php')();

$controller = new SalleController(
    new EloquentSalleRepository(),
    new SalleValidator(),
    new View(__DIR__ . '/../templates')
);

$html = $controller->index();
echo "Longueur du HTML généré : " . strlen($html) . " caractères\n";
echo str_contains($html, '<table>') ? "✅ La table des salles est bien présente\n" : "❌ Table absente\n";