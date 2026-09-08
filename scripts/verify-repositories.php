<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Repository\EloquentSalleRepository;
use App\Repository\EloquentReservationRepository;
use Dotenv\Dotenv;

Dotenv::createImmutable(__DIR__ . '/..')->load();
(require __DIR__ . '/../config/database.php')();

$salleRepo = new EloquentSalleRepository();
$salles = $salleRepo->all();
echo "Nombre de salles : " . $salles->count() . "\n";

$premiereSalle = $salles->first();
echo "Première salle : {$premiereSalle->nom}\n";

$reservationRepo = new EloquentReservationRepository();
$conflit = $reservationRepo->findConflit(
    $premiereSalle->id,
    new DateTimeImmutable('2026-09-10 10:00:00'),
    new DateTimeImmutable('2026-09-10 12:00:00')
);
echo "Conflit trouvé : " . ($conflit ? 'oui' : 'non, aucune réservation existante sur ce créneau') . "\n";