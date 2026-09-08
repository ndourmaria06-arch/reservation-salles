<h1><?= isset($salle) ? 'Modifier la salle' : 'Ajouter une salle' ?></h1>

<form method="POST" action="<?= isset($salle) ? '/salles/' . (int) $salle->id . '/edit' : '/salles' ?>">

    <label for="nom">Nom</label>
    <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($valeurs['nom'] ?? $salle->nom ?? '', ENT_QUOTES) ?>">
    <?php if (!empty($erreurs['nom'])): ?>
        <p class="erreur"><?= htmlspecialchars($erreurs['nom'], ENT_QUOTES) ?></p>
    <?php endif; ?>

    <label for="batiment">Bâtiment</label>
    <input type="text" id="batiment" name="batiment" value="<?= htmlspecialchars($valeurs['batiment'] ?? $salle->batiment ?? '', ENT_QUOTES) ?>">
    <?php if (!empty($erreurs['batiment'])): ?>
        <p class="erreur"><?= htmlspecialchars($erreurs['batiment'], ENT_QUOTES) ?></p>
    <?php endif; ?>

    <label for="capacite">Capacité</label>
    <input type="number" id="capacite" name="capacite" value="<?= htmlspecialchars((string) ($valeurs['capacite'] ?? $salle->capacite ?? ''), ENT_QUOTES) ?>">
    <?php if (!empty($erreurs['capacite'])): ?>
        <p class="erreur"><?= htmlspecialchars($erreurs['capacite'], ENT_QUOTES) ?></p>
    <?php endif; ?>

    <label for="type">Type</label>
    <select id="type" name="type">
        <?php foreach (['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion'] as $type): ?>
            <option value="<?= $type ?>" <?= ($valeurs['type'] ?? $salle->type ?? '') === $type ? 'selected' : '' ?>>
                <?= htmlspecialchars($type, ENT_QUOTES) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (!empty($erreurs['type'])): ?>
        <p class="erreur"><?= htmlspecialchars($erreurs['type'], ENT_QUOTES) ?></p>
    <?php endif; ?>

    <label for="active">
        <input type="checkbox" id="active" name="active" value="1" <?= ($valeurs['active'] ?? $salle->active ?? true) ? 'checked' : '' ?>>
        Active
    </label>

    <button type="submit">Enregistrer</button>
</form>