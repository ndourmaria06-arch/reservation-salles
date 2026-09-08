<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Controller\ReservationController;
use App\Repository\EloquentReservationRepository;
use App\Repository\EloquentSalleRepository;
use App\Service\AnnulerReservationService;
use App\Service\CreerReservationService;
use App\Validation\ReservationValidator;
use App\View\View;
use Dotenv\Dotenv;

Dotenv::createImmutable(__DIR__ . '/..')->load();
(require __DIR__ . '/../config/database.php')();

$salleRepo = new EloquentSalleRepository();
$reservationRepo = new EloquentReservationRepository();

$controller = new ReservationController(
    $reservationRepo,
    $salleRepo,
    new ReservationValidator(),
    new CreerReservationService($salleRepo, $reservationRepo),
    new AnnulerReservationService($reservationRepo),
    new View(__DIR__ . '/../templates')
);

$html = $controller->index();
echo "Longueur du HTML généré : " . strlen($html) . " caractères\n";
echo str_contains($html, '<table>') ? "✅ La table des réservations est bien présente\n" : "❌ Table absente\n";