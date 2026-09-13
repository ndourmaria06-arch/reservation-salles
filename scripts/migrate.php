<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

Dotenv::createImmutable(__DIR__ . '/..')->safeLoad();

$initDatabase = require __DIR__ . '/../config/database.php';
$capsule = $initDatabase();

$migrationsDir = __DIR__ . '/../database/migrations';
$files = glob($migrationsDir . '/*.php');
sort($files);

foreach ($files as $file) {
    $migration = require $file;
    $migration($capsule);
    echo "Migration exécutée : " . basename($file) . "\n";
}

echo "Toutes les migrations sont terminées.\n";
