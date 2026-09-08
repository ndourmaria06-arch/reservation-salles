<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use DateTimeImmutable;

final class CreerReservationService
{
    private const DUREE_MAX_HEURES = 4;

    public function __construct(
        private readonly SalleRepositoryInterface $salles,
        private readonly ReservationRepositoryInterface $reservations,
    ) {
    }

    public function creer(CreerReservationDTO $dto): Reservation
    {
        // 1. la salle existe
        $salle = $this->salles->find($dto->salleId);
        if ($salle === null) {
            throw new SalleIndisponibleException("La salle demandée n'existe pas.");
        }

        // 2. la salle est active
        if (!$salle->active) {
            throw new SalleIndisponibleException('Cette salle ne peut pas être réservée.');
        }

        // 3. le début précède la fin
        if ($dto->dateDebut >= $dto->dateFin) {
            throw new SalleIndisponibleException('La date de début doit précéder la date de fin.');
        }

        // 4. durée maximale de 4 heures
        $dureeEnHeures = ($dto->dateFin->getTimestamp() - $dto->dateDebut->getTimestamp()) / 3600;
        if ($dureeEnHeures > self::DUREE_MAX_HEURES) {
            throw new SalleIndisponibleException('Une réservation ne peut pas dépasser quatre heures.');
        }

        // 5. la réservation doit commencer dans le futur
        if ($dto->dateDebut <= new DateTimeImmutable()) {
            throw new SalleIndisponibleException('La réservation doit commencer dans le futur.');
        }

        // 6. recherche de chevauchement
        $conflit = $this->reservations->findConflit($dto->salleId, $dto->dateDebut, $dto->dateFin);
        if ($conflit !== null) {
            throw new SalleIndisponibleException('La salle est indisponible pendant cette période.');
        }

        // 7-8. créer et enregistrer la réservation
        $reservation = new Reservation([
            'salle_id' => $dto->salleId,
            'responsable' => $dto->responsable,
            'email' => $dto->email,
            'motif' => $dto->motif,
            'date_debut' => $dto->dateDebut,
            'date_fin' => $dto->dateFin,
            'statut' => 'confirmée',
        ]);

        // 9. retourner le résultat
        return $this->reservations->save($reservation);
    }
}