<h1>Liste des réservations</h1>

<a href="/reservations/create" class="btn">Nouvelle réservation</a>

<div class="filter-bar">
    <form method="GET" action="/reservations">
        <div class="form-group">
            <label for="salle_id">Filtrer par salle</label>
            <select id="salle_id" name="salle_id" onchange="this.form.submit()">
                <option value="">Toutes les salles</option>
                <?php foreach ($salles as $salle): ?>
                    <option value="<?= (int) $salle->id ?>" <?= (isset($salleId) && $salleId === $salle->id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($salle->nom, ENT_QUOTES) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Salle</th>
            <th>Responsable</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Statut</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?= htmlspecialchars($reservation->salle->nom ?? '—', ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($reservation->responsable, ENT_QUOTES) ?></td>
                <td><?= $reservation->date_debut->format('d/m/Y H:i') ?></td>
                <td><?= $reservation->date_fin->format('d/m/Y H:i') ?></td>
                <td>
                    <span class="badge <?= $reservation->statut === 'confirmée' ? 'badge-confirmee' : 'badge-annulee' ?>">
                        <?= htmlspecialchars($reservation->statut, ENT_QUOTES) ?>
                    </span>
                </td>
                <td>
                    <a href="/reservations/<?= (int) $reservation->id ?>">Détail</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>