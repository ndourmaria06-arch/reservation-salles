<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$initDatabase = require __DIR__ . '/config/database.php';
$capsule = $initDatabase();

try {
    $pdo = $capsule->getConnection()->getPdo();
    echo "Connexion MySQL réussie sur la base : " . $capsule->getConnection()->getDatabaseName() . "\n";
} catch (\Throwable $e) {
    echo "Échec de connexion : " . $e->getMessage() . "\n";
}

