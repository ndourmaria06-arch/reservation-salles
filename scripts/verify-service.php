<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Repository\EloquentSalleRepository;
use App\Repository\EloquentReservationRepository;
use App\Service\CreerReservationService;
use Dotenv\Dotenv;

Dotenv::createImmutable(__DIR__ . '/..')->load();
(require __DIR__ . '/../config/database.php')();

$service = new CreerReservationService(
    new EloquentSalleRepository(),
    new EloquentReservationRepository()
);

$salleId = 2; // Salle B12, active

function tester(string $label, callable $action): void
{
    try {
        $action();
        echo "❌ {$label} : aucune exception levée (inattendu)\n";
    } catch (SalleIndisponibleException $e) {
        echo "✅ {$label} : {$e->getMessage()}\n";
    }
}

// Scénario 5 : durée excessive
tester('Durée excessive (6h)', function () use ($service, $salleId) {
    $service->creer(CreerReservationDTO::fromArray([
        'salle_id' => $salleId,
        'responsable' => 'Test',
        'email' => 'test@universite.sn',
        'motif' => 'Test durée excessive',
        'date_debut' => (new DateTimeImmutable('+1 day 08:00'))->format('Y-m-d H:i:s'),
        'date_fin' => (new DateTimeImmutable('+1 day 14:00'))->format('Y-m-d H:i:s'),
    ]));
});

// Scénario : date passée
tester('Date passée', function () use ($service, $salleId) {
    $service->creer(CreerReservationDTO::fromArray([
        'salle_id' => $salleId,
        'responsable' => 'Test',
        'email' => 'test@universite.sn',
        'motif' => 'Test date passée',
        'date_debut' => (new DateTimeImmutable('-1 day'))->format('Y-m-d H:i:s'),
        'date_fin' => (new DateTimeImmutable('-1 day +2 hours'))->format('Y-m-d H:i:s'),
    ]));
});

// Réservation valide (scénario 1)
$reservation = $service->creer(CreerReservationDTO::fromArray([
    'salle_id' => $salleId,
    'responsable' => 'Awa Ndiaye',
    'email' => 'awa.ndiaye@universite.sn',
    'motif' => "Cours d'architecture logicielle",
    'date_debut' => (new DateTimeImmutable('+1 day 10:00'))->format('Y-m-d H:i:s'),
    'date_fin' => (new DateTimeImmutable('+1 day 12:00'))->format('Y-m-d H:i:s'),
]));
echo "✅ Réservation valide créée (id {$reservation->id})\n";

// Scénario 2 : chevauchement
tester('Chevauchement (11h-13h sur 10h-12h existant)', function () use ($service, $salleId) {
    $service->creer(CreerReservationDTO::fromArray([
        'salle_id' => $salleId,
        'responsable' => 'Test',
        'email' => 'test@universite.sn',
        'motif' => 'Test chevauchement',
        'date_debut' => (new DateTimeImmutable('+1 day 11:00'))->format('Y-m-d H:i:s'),
        'date_fin' => (new DateTimeImmutable('+1 day 13:00'))->format('Y-m-d H:i:s'),
    ]));
});

// Scénario 3 : réservations voisines (12h-14h après 10h-12h) — doit réussir
$voisine = $service->creer(CreerReservationDTO::fromArray([
    'salle_id' => $salleId,
    'responsable' => 'Test Voisine',
    'email' => 'test2@universite.sn',
    'motif' => 'Test réservation voisine sans chevauchement',
    'date_debut' => (new DateTimeImmutable('+1 day 12:00'))->format('Y-m-d H:i:s'),
    'date_fin' => (new DateTimeImmutable('+1 day 14:00'))->format('Y-m-d H:i:s'),
]));
echo "✅ Réservation voisine créée sans conflit (id {$voisine->id})\n";

// Nettoyage
$reservation->delete();
$voisine->delete();
echo "Nettoyage effectué.\n";