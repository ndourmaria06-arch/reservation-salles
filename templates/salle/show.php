<h1><?= htmlspecialchars($salle->nom, ENT_QUOTES) ?></h1>

<p>Bâtiment : <?= htmlspecialchars($salle->batiment, ENT_QUOTES) ?></p>
<p>Capacité : <?= (int) $salle->capacite ?> personnes</p>
<p>Type : <?= htmlspecialchars($salle->type, ENT_QUOTES) ?></p>
<p>Statut : <?= $salle->active ? 'Active' : 'Inactive' ?></p>

<a href="/salles/<?= (int) $salle->id ?>/edit">Modifier</a>
<a href="/salles">Retour à la liste</a>

<h2>Réservations pour cette salle</h2>
<?php if ($salle->reservations->isEmpty()): ?>
    <p>Aucune réservation pour cette salle.</p>
<?php else: ?>
    <ul>
        <?php foreach ($salle->reservations as $reservation): ?>
            <li>
                <?= htmlspecialchars($reservation->responsable, ENT_QUOTES) ?> —
                <?= htmlspecialchars($reservation->motif, ENT_QUOTES) ?>
                (<?= $reservation->statut ?>)
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>