<h1>Nouvelle réservation</h1>

<form method="POST" action="/reservations">

    <div class="form-group">
        <label for="salle_id">Salle</label>
        <select id="salle_id" name="salle_id">
            <?php foreach ($salles as $salle): ?>
                <option value="<?= (int) $salle->id ?>" <?= (($valeurs['salle_id'] ?? '') == $salle->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($salle->nom, ENT_QUOTES) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($erreurs['salle_id'])): ?>
            <p class="erreur"><?= htmlspecialchars($erreurs['salle_id'], ENT_QUOTES) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="responsable">Responsable</label>
        <input type="text" id="responsable" name="responsable" value="<?= htmlspecialchars($valeurs['responsable'] ?? '', ENT_QUOTES) ?>">
        <?php if (!empty($erreurs['responsable'])): ?>
            <p class="erreur"><?= htmlspecialchars($erreurs['responsable'], ENT_QUOTES) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($valeurs['email'] ?? '', ENT_QUOTES) ?>">
        <?php if (!empty($erreurs['email'])): ?>
            <p class="erreur"><?= htmlspecialchars($erreurs['email'], ENT_QUOTES) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="motif">Motif</label>
        <input type="text" id="motif" name="motif" value="<?= htmlspecialchars($valeurs['motif'] ?? '', ENT_QUOTES) ?>">
        <?php if (!empty($erreurs['motif'])): ?>
            <p class="erreur"><?= htmlspecialchars($erreurs['motif'], ENT_QUOTES) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="date_debut">Date de début</label>
        <input type="datetime-local" id="date_debut" name="date_debut" value="<?= htmlspecialchars($valeurs['date_debut'] ?? '', ENT_QUOTES) ?>">
        <?php if (!empty($erreurs['date_debut'])): ?>
            <p class="erreur"><?= htmlspecialchars($erreurs['date_debut'], ENT_QUOTES) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="date_fin">Date de fin</label>
        <input type="datetime-local" id="date_fin" name="date_fin" value="<?= htmlspecialchars($valeurs['date_fin'] ?? '', ENT_QUOTES) ?>">
        <?php if (!empty($erreurs['date_fin'])): ?>
            <p class="erreur"><?= htmlspecialchars($erreurs['date_fin'], ENT_QUOTES) ?></p>
        <?php endif; ?>
    </div>

    <?php if (!empty($erreurs['general'])): ?>
        <p class="erreur"><?= htmlspecialchars($erreurs['general'], ENT_QUOTES) ?></p>
    <?php endif; ?>

    <button type="submit" class="btn">Réserver</button>
</form>