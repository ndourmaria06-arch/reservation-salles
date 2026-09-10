<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;
use Illuminate\Support\Collection;

final class InMemorySalleRepository implements SalleRepositoryInterface
{
    /** @var array<int, Salle> */
    private array $salles = [];

    public function ajouter(Salle $salle): void
    {
        $this->salles[$salle->id] = $salle;
    }

    public function all(): Collection
    {
        return new Collection(array_values($this->salles));
    }

    public function find(int $id): ?Salle
    {
        return $this->salles[$id] ?? null;
    }

    public function save(Salle $salle): Salle
    {
        $this->salles[$salle->id] = $salle;

        return $salle;
    }
}