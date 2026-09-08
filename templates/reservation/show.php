<h1>Réservation #<?= (int) $reservation->id ?></h1>

<p>Salle : <?= htmlspecialchars($reservation->salle->nom, ENT_QUOTES) ?></p>
<p>Responsable : <?= htmlspecialchars($reservation->responsable, ENT_QUOTES) ?></p>
<p>Email : <?= htmlspecialchars($reservation->email, ENT_QUOTES) ?></p>
<p>Motif : <?= htmlspecialchars($reservation->motif, ENT_QUOTES) ?></p>
<p>Début : <?= $reservation->date_debut->format('d/m/Y H:i') ?></p>
<p>Fin : <?= $reservation->date_fin->format('d/m/Y H:i') ?></p>
<p>Statut : <?= htmlspecialchars($reservation->statut, ENT_QUOTES) ?></p>

<?php if ($reservation->statut === 'confirmée'): ?>
    <form method="POST" action="/reservations/<?= (int) $reservation->id ?>/cancel">
        <button type="submit">Annuler cette réservation</button>
    </form>
<?php endif; ?>

<a href="/reservations">Retour à la liste</a>