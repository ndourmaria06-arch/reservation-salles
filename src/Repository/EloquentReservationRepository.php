<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Reservation;
use DateTimeImmutable;
use Illuminate\Support\Collection;

final class EloquentReservationRepository implements ReservationRepositoryInterface
{
    public function all(): Collection
    {
        return Reservation::query()->with('salle')->orderByDesc('date_debut')->get();
    }

    public function find(int $id): ?Reservation
    {
        return Reservation::query()->with('salle')->find($id);
    }

    public function findBySalle(int $salleId): Collection
    {
        return Reservation::query()
            ->where('salle_id', $salleId)
            ->orderByDesc('date_debut')
            ->get();
    }

    public function findConflit(int $salleId, DateTimeImmutable $debut, DateTimeImmutable $fin): ?Reservation
    {
        return Reservation::query()
            ->where('salle_id', $salleId)
            ->where('statut', 'confirmée')
            ->where('date_debut', '<', $fin->format('Y-m-d H:i:s'))
            ->where('date_fin', '>', $debut->format('Y-m-d H:i:s'))
            ->first();
    }

    public function save(Reservation $reservation): Reservation
    {
        $reservation->save();

        return $reservation;
    }

    public function annuler(Reservation $reservation): Reservation
    {
        $reservation->statut = 'annulée';
        $reservation->save();

        return $reservation;
    }
}