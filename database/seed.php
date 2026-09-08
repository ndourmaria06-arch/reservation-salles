<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Model\Salle;
use Dotenv\Dotenv;

Dotenv::createImmutable(__DIR__ . '/..')->load();
(require __DIR__ . '/../config/database.php')();

$salles = [
    ['nom' => 'Amphithéâtre A', 'batiment' => 'Bâtiment Principal', 'capacite' => 250, 'type' => 'amphitheatre', 'active' => true],
    ['nom' => 'Salle B12', 'batiment' => 'Bâtiment B', 'capacite' => 40, 'type' => 'cours', 'active' => true],
    ['nom' => 'Laboratoire Chimie', 'batiment' => 'Bâtiment Sciences', 'capacite' => 24, 'type' => 'laboratoire', 'active' => true],
    ['nom' => 'Salle Informatique 1', 'batiment' => 'Bâtiment Informatique', 'capacite' => 30, 'type' => 'informatique', 'active' => true],
    ['nom' => 'Salle de réunion', 'batiment' => 'Bâtiment Administration', 'capacite' => 12, 'type' => 'reunion', 'active' => true],
];

foreach ($salles as $data) {
    Salle::firstOrCreate(
        ['nom' => $data['nom']],
        $data
    );
}

echo "Données initiales insérées (ou déjà présentes).\n";

