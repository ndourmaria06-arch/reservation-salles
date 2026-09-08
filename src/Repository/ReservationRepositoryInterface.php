<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Reservation;
use DateTimeImmutable;
use Illuminate\Support\Collection;

interface ReservationRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Reservation;

    public function findBySalle(int $salleId): Collection;

    public function findConflit(int $salleId, DateTimeImmutable $debut, DateTimeImmutable $fin): ?Reservation;

    public function save(Reservation $reservation): Reservation;

    public function annuler(Reservation $reservation): Reservation;

}