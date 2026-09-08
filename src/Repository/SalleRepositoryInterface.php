<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Salle;
use Illuminate\Support\Collection;

interface SalleRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Salle;

    public function save(Salle $salle): Salle;
}