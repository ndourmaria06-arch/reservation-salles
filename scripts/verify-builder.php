<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\DTO\CreerReservationDTOBuilder;

$dto = (new CreerReservationDTOBuilder())
    ->avecSalleId(2)
    ->avecResponsable('Awa Ndiaye')
    ->avecEmail('awa.ndiaye@universite.sn')
    ->avecMotif("Cours d'architecture logicielle")
    ->avecDateDebut(new DateTimeImmutable('+1 day 10:00'))
    ->avecDateFin(new DateTimeImmutable('+1 day 12:00'))
    ->build();

echo "DTO construit via Builder : salleId={$dto->salleId}, responsable={$dto->responsable}\n";
echo "dateDebut est une DateTimeImmutable : " . ($dto->dateDebut instanceof DateTimeImmutable ? 'oui' : 'non') . "\n";