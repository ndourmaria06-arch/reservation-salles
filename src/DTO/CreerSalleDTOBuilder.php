<?php

declare(strict_types=1);

namespace App\DTO;

use RuntimeException;

final class CreerSalleDTOBuilder
{
    private ?string $nom = null;
    private ?string $batiment = null;
    private ?int $capacite = null;
    private ?string $type = null;
    private bool $active = true;

    public function avecNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function avecBatiment(string $batiment): self
    {
        $this->batiment = $batiment;

        return $this;
    }

    public function avecCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function avecType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function avecActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function build(): CreerSalleDTO
    {
        if ($this->nom === null || $this->batiment === null || $this->capacite === null || $this->type === null) {
            throw new RuntimeException('Tous les champs obligatoires du DTO Salle doivent être renseignés avant build().');
        }

        return new CreerSalleDTO(
            nom: $this->nom,
            batiment: $this->batiment,
            capacite: $this->capacite,
            type: $this->type,
            active: $this->active,
        );
    }
}