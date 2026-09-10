<?php

declare(strict_types=1);

use App\Application;
use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Repository\EloquentReservationRepository;
use App\Repository\EloquentSalleRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\View\View;
use Illuminate\Database\Capsule\Manager as Capsule;

use function DI\autowire;
use function DI\factory;
use function DI\get;

return [
    // Connexion à la base : construite une seule fois via notre config/database.php existant
    Capsule::class => factory(function (): Capsule {
        $initDatabase = require __DIR__ . '/database.php';

        return $initDatabase();
    }),

    // Interfaces -> implémentations concrètes
    SalleRepositoryInterface::class => autowire(EloquentSalleRepository::class),
    ReservationRepositoryInterface::class => autowire(EloquentReservationRepository::class),

    // Le moteur de vues, avec le chemin des templates injecté
    View::class => factory(function (): View {
        return new View(dirname(__DIR__) . '/templates');
    }),

    // Contrôleurs (autowiring : PHP-DI construit automatiquement à partir du constructeur)
    SalleController::class => autowire(SalleController::class),
    ReservationController::class => autowire(ReservationController::class),

    // Point d'entrée de l'application
    Application::class => autowire(Application::class),
];