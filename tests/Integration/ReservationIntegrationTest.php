<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Model\Salle;
use App\Repository\EloquentReservationRepository;
use DateTimeImmutable;

final class ReservationIntegrationTest extends DatabaseTestCase
{
    public function testRechercheDeChevauchement(): void
    {
        $salle = Salle::create([
            'nom' => 'TEST_Salle Chevauchement',
            'batiment' => 'Bâtiment Test',
            'capacite' => 25,
            'type' => 'cours',
            'active' => true,
        ]);

        $salle->reservations()->create([
            'responsable' => 'Test',
            'email' => 'test@universite.sn',
            'motif' => 'Réservation existante',
            'date_debut' => '2026-12-05 10:00:00',
            'date_fin' => '2026-12-05 12:00:00',
            'statut' => 'confirmée',
        ]);

        $repository = new EloquentReservationRepository();
        $conflit = $repository->findConflit(
            $salle->id,
            new DateTimeImmutable('2026-12-05 11:00:00'),
            new DateTimeImmutable('2026-12-05 13:00:00')
        );

        $this->assertNotNull($conflit);
    }

    public function testAnnulationDuneReservation(): void
    {
        $salle = Salle::create([
            'nom' => 'TEST_Salle Annulation',
            'batiment' => 'Bâtiment Test',
            'capacite' => 25,
            'type' => 'cours',
            'active' => true,
        ]);

        $reservation = $salle->reservations()->create([
            'responsable' => 'Test',
            'email' => 'test@universite.sn',
            'motif' => 'Réservation à annuler',
            'date_debut' => '2026-12-06 10:00:00',
            'date_fin' => '2026-12-06 12:00:00',
            'statut' => 'confirmée',
        ]);

        $repository = new EloquentReservationRepository();
        $repository->annuler($reservation);

        $this->assertSame('annulée', $reservation->fresh()->statut);
    }
}