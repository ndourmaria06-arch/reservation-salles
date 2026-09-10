<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Validation\SalleValidator;
use PHPUnit\Framework\TestCase;

final class SalleValidatorTest extends TestCase
{
    private SalleValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new SalleValidator();
    }

    public function testCapaciteNegativeEstRejetee(): void
    {
        $resultat = $this->validator->validate([
            'nom' => 'Salle Test',
            'batiment' => 'Bâtiment A',
            'capacite' => -5,
            'type' => 'cours',
            'active' => true,
        ]);

        $this->assertFalse($resultat->isValid());
        $this->assertArrayHasKey('capacite', $resultat->errors());
    }

    public function testTypeInconnuEstRejete(): void
    {
        $resultat = $this->validator->validate([
            'nom' => 'Salle Test',
            'batiment' => 'Bâtiment A',
            'capacite' => 30,
            'type' => 'type_qui_nexiste_pas',
            'active' => true,
        ]);

        $this->assertFalse($resultat->isValid());
        $this->assertArrayHasKey('type', $resultat->errors());
    }

    public function testSalleValideEstAcceptee(): void
    {
        $resultat = $this->validator->validate([
            'nom' => 'Salle Test',
            'batiment' => 'Bâtiment A',
            'capacite' => 30,
            'type' => 'cours',
            'active' => true,
        ]);

        $this->assertTrue($resultat->isValid());
    }
}