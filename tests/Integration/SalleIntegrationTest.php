<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Model\Salle;

final class SalleIntegrationTest extends DatabaseTestCase
{
    public function testCreationDuneSalleAvecEloquent(): void
    {
        $salle = Salle::create([
            'nom' => 'TEST_Salle Intégration',
            'batiment' => 'Bâtiment Test',
            'capacite' => 25,
            'type' => 'cours',
            'active' => true,
        ]);

        $this->assertNotNull($salle->id);
        $this->assertDatabaseHasSalle($salle->id);
    }

    public function testRelationSalleReservations(): void
    {
        $salle = Salle::create([
            'nom' => 'TEST_Salle Relation',
            'batiment' => 'Bâtiment Test',
            'capacite' => 25,
            'type' => 'cours',
            'active' => true,
        ]);

        $salle->reservations()->create([
            'responsable' => 'Test Relation',
            'email' => 'test@universite.sn',
            'motif' => 'Test de la relation salle-réservations',
            'date_debut' => '2026-12-01 10:00:00',
            'date_fin' => '2026-12-01 12:00:00',
            'statut' => 'confirmée',
        ]);

        $this->assertSame(1, $salle->reservations()->count());
        $this->assertSame($salle->id, $salle->reservations()->first()->salle_id);
    }

    private function assertDatabaseHasSalle(int $id): void
    {
        $this->assertNotNull(Salle::find($id));
    }
}