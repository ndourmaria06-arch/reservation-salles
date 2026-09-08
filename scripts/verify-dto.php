<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\DTO\CreerReservationDTO;

$dto = CreerReservationDTO::fromArray([
    'salle_id' => '2',
    'responsable' => 'Awa Ndiaye',
    'email' => 'awa.ndiaye@universite.sn',
    'motif' => "Cours d'architecture logicielle",
    'date_debut' => '2026-09-10 10:00:00',
    'date_fin' => '2026-09-10 12:00:00',
]);

echo "salleId (int) : " . $dto->salleId . "\n";
echo "dateDebut est une DateTimeImmutable : " . ($dto->dateDebut instanceof DateTimeImmutable ? 'oui' : 'non') . "\n";
echo "dateDebut formatée : " . $dto->dateDebut->format('d/m/Y H:i') . "\n";