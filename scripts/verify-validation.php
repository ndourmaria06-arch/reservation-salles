<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Validation\SalleValidator;
use App\Validation\ReservationValidator;

$salleValidator = new SalleValidator();

$resultatOk = $salleValidator->validate([
    'nom' => 'Amphithéâtre B',
    'batiment' => 'Bâtiment C',
    'capacite' => 80,
    'type' => 'amphitheatre',
    'active' => true,
]);
echo "Salle valide : " . ($resultatOk->isValid() ? 'oui' : 'non') . "\n";

$resultatKo = $salleValidator->validate([
    'nom' => 'A',
    'batiment' => '',
    'capacite' => -5,
    'type' => 'inconnu',
    'active' => 'oui',
]);
echo "Salle invalide détectée : " . ($resultatKo->isValid() ? 'oui' : 'non') . "\n";
print_r($resultatKo->errors());

$reservationValidator = new ReservationValidator();
$resultatResa = $reservationValidator->validate([
    'salle_id' => 1,
    'responsable' => 'Awa Ndiaye',
    'email' => 'pas-un-email',
    'motif' => 'TP',
    'date_debut' => '2026-09-10 10:00:00',
    'date_fin' => '2026-09-10 12:00:00',
]);
echo "Réservation valide : " . ($resultatResa->isValid() ? 'oui' : 'non') . "\n";
print_r($resultatResa->errors());