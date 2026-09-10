<?php

declare(strict_types=1);

namespace Tests\Integration;

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;
use PHPUnit\Framework\TestCase;

abstract class DatabaseTestCase extends TestCase
{
    protected static ?Capsule $capsule = null;

    public static function setUpBeforeClass(): void
    {
        if (self::$capsule === null) {
            $root = dirname(__DIR__, 2);
            Dotenv::createImmutable($root)->load();

            $initDatabase = require $root . '/config/database.php';
            self::$capsule = $initDatabase();
        }
    }

    protected function tearDown(): void
    {
        // Nettoyage : on supprime les données créées par le test
        Capsule::table('reservations')->truncate();
        Capsule::table('salles')->where('nom', 'LIKE', 'TEST_%')->delete();
    }
}