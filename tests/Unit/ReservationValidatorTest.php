<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Validation\ReservationValidator;
use PHPUnit\Framework\TestCase;

final class ReservationValidatorTest extends TestCase
{
    private ReservationValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new ReservationValidator();
    }

    private function donneesValides(array $overrides = []): array
    {
        return array_merge([
            'salle_id' => 1,
            'responsable' => 'Awa Ndiaye',
            'email' => 'awa.ndiaye@universite.sn',
            'motif' => 'Cours de test',
            'date_debut' => '2026-09-15 10:00',
            'date_fin' => '2026-09-15 12:00',
        ], $overrides);
    }

    public function testEmailInvalideEstRejete(): void
    {
        $resultat = $this->validator->validate($this->donneesValides(['email' => 'pas-un-email']));

        $this->assertFalse($resultat->isValid());
        $this->assertArrayHasKey('email', $resultat->errors());
    }

    public function testResponsableVideEstRejete(): void
    {
        $resultat = $this->validator->validate($this->donneesValides(['responsable' => '']));

        $this->assertFalse($resultat->isValid());
        $this->assertArrayHasKey('responsable', $resultat->errors());
    }

    public function testDateIncorrecteEstRejetee(): void
    {
        $resultat = $this->validator->validate($this->donneesValides(['date_debut' => 'pas-une-date']));

        $this->assertFalse($resultat->isValid());
        $this->assertArrayHasKey('date_debut', $resultat->errors());
    }

    public function testReservationValideEstAcceptee(): void
    {
        $resultat = $this->validator->validate($this->donneesValides());

        $this->assertTrue($resultat->isValid());
    }
}