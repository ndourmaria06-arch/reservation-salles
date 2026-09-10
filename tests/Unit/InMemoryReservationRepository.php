<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Support\Collection;

final class InMemoryReservationRepository implements ReservationRepositoryInterface
{
    /** @var array<int, Reservation> */
    private array $reservations = [];
    private int $prochainId = 1;

    public function all(): Collection
    {
        return new Collection(array_values($this->reservations));
    }

    public function find(int $id): ?Reservation
    {
        return $this->reservations[$id] ?? null;
    }

    public function findBySalle(int $salleId): Collection
    {
        return new Collection(
            array_values(array_filter(
                $this->reservations,
                static fn (Reservation $r) => $r->salle_id === $salleId
            ))
        );
    }

    public function findConflit(int $salleId, DateTimeImmutable $debut, DateTimeImmutable $fin): ?Reservation
    {
        foreach ($this->reservations as $reservation) {
            if ($reservation->salle_id !== $salleId) {
                continue;
            }
            if ($reservation->statut !== 'confirmée') {
                continue;
            }

            $existDebut = $reservation->date_debut;
            $existFin = $reservation->date_fin;

            if ($debut < $existFin && $fin > $existDebut) {
                return $reservation;
            }
        }

        return null;
    }

    public function save(Reservation $reservation): Reservation
    {
        if ($reservation->id === null) {
            $reservation->id = $this->prochainId++;
        }

        $this->reservations[$reservation->id] = $reservation;

        return $reservation;
    }

    public function annuler(Reservation $reservation): Reservation
    {
        $reservation->statut = 'annulée';
        $this->reservations[$reservation->id] = $reservation;

        return $reservation;
    }
}