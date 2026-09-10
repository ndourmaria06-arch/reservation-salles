<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Model\Salle;
use App\Service\CreerReservationService;
use DateTimeImmutable;

final class CreerReservationServiceTest extends TestCase
{
    private InMemorySalleRepository $salles;
    private InMemoryReservationRepository $reservations;
    private CreerReservationService $service;

    protected function setUp(): void
    {
        $this->salles = new InMemorySalleRepository();
        $this->reservations = new InMemoryReservationRepository();
        $this->service = new CreerReservationService($this->salles, $this->reservations);

        $salleActive = new Salle([
            'nom' => 'Salle Test',
            'batiment' => 'Bâtiment Test',
            'capacite' => 30,
            'type' => 'cours',
            'active' => true,
        ]);
        $salleActive->id = 1;
        $this->salles->ajouter($salleActive);

        $salleInactive = new Salle([
            'nom' => 'Salle Inactive',
            'batiment' => 'Bâtiment Test',
            'capacite' => 20,
            'type' => 'cours',
            'active' => false,
        ]);
        $salleInactive->id = 2;
        $this->salles->ajouter($salleInactive);
    }

    private function dto(array $overrides = []): CreerReservationDTO
    {
        $defaults = [
            'salle_id' => 1,
            'responsable' => 'Awa Ndiaye',
            'email' => 'awa.ndiaye@universite.sn',
            'motif' => 'Cours de test',
            'date_debut' => (new DateTimeImmutable('+1 day 10:00'))->format('Y-m-d H:i:s'),
            'date_fin' => (new DateTimeImmutable('+1 day 12:00'))->format('Y-m-d H:i:s'),
        ];

        return CreerReservationDTO::fromArray(array_merge($defaults, $overrides));
    }

    public function testReservationValideEstCreee(): void
    {
        $reservation = $this->service->creer($this->dto());

        $this->assertSame('confirmée', $reservation->statut);
    }

    public function testSalleInexistanteLeveException(): void
    {
        $this->expectException(SalleIndisponibleException::class);
        $this->service->creer($this->dto(['salle_id' => 999]));
    }

    public function testSalleInactiveLeveException(): void
    {
        $this->expectException(SalleIndisponibleException::class);
        $this->service->creer($this->dto(['salle_id' => 2]));
    }

    public function testDateFinAnterieureADebutLeveException(): void
    {
        $this->expectException(SalleIndisponibleException::class);
        $this->service->creer($this->dto([
            'date_debut' => (new DateTimeImmutable('+1 day 12:00'))->format('Y-m-d H:i:s'),
            'date_fin' => (new DateTimeImmutable('+1 day 10:00'))->format('Y-m-d H:i:s'),
        ]));
    }

    public function testDureeSuperieureAQuatreHeuresLeveException(): void
    {
        $this->expectException(SalleIndisponibleException::class);
        $this->service->creer($this->dto([
            'date_debut' => (new DateTimeImmutable('+1 day 08:00'))->format('Y-m-d H:i:s'),
            'date_fin' => (new DateTimeImmutable('+1 day 14:00'))->format('Y-m-d H:i:s'),
        ]));
    }

    public function testDatePasseeLeveException(): void
    {
        $this->expectException(SalleIndisponibleException::class);
        $this->service->creer($this->dto([
            'date_debut' => (new DateTimeImmutable('-1 day'))->format('Y-m-d H:i:s'),
            'date_fin' => (new DateTimeImmutable('-1 day +2 hours'))->format('Y-m-d H:i:s'),
        ]));
    }

    public function testConflitAvecReservationExistanteLeveException(): void
    {
        $this->service->creer($this->dto([
            'date_debut' => (new DateTimeImmutable('+1 day 10:00'))->format('Y-m-d H:i:s'),
            'date_fin' => (new DateTimeImmutable('+1 day 12:00'))->format('Y-m-d H:i:s'),
        ]));

        $this->expectException(SalleIndisponibleException::class);
        $this->service->creer($this->dto([
            'date_debut' => (new DateTimeImmutable('+1 day 11:00'))->format('Y-m-d H:i:s'),
            'date_fin' => (new DateTimeImmutable('+1 day 13:00'))->format('Y-m-d H:i:s'),
        ]));
    }

    public function testReservationVoisineSansChevauchementEstAcceptee(): void
    {
        $this->service->creer($this->dto([
            'date_debut' => (new DateTimeImmutable('+1 day 10:00'))->format('Y-m-d H:i:s'),
            'date_fin' => (new DateTimeImmutable('+1 day 12:00'))->format('Y-m-d H:i:s'),
        ]));

        $reservation = $this->service->creer($this->dto([
            'date_debut' => (new DateTimeImmutable('+1 day 12:00'))->format('Y-m-d H:i:s'),
            'date_fin' => (new DateTimeImmutable('+1 day 14:00'))->format('Y-m-d H:i:s'),
        ]));

        $this->assertSame('confirmée', $reservation->statut);
    }
}