<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Salle;
use Illuminate\Support\Collection;

final class EloquentSalleRepository implements SalleRepositoryInterface
{
    public function all(): Collection
    {
        return Salle::query()->orderBy('nom')->get();
    }

    public function find(int $id): ?Salle
    {
        return Salle::query()->find($id);
    }

    public function save(Salle $salle): Salle
    {
        $salle->save();

        return $salle;
    }
}