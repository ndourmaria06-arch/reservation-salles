<h1>Liste des salles</h1>

<a href="/salles/create">+ Ajouter une salle</a>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Bâtiment</th>
            <th>Capacité</th>
            <th>Type</th>
            <th>Statut</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($salles as $salle): ?>
            <tr>
                <td><?= htmlspecialchars($salle->nom, ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($salle->batiment, ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars((string) $salle->capacite, ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($salle->type, ENT_QUOTES) ?></td>
                <td><?= $salle->active ? 'Active' : 'Inactive' ?></td>
                <td>
                    <a href="/salles/<?= (int) $salle->id ?>">Détail</a>
                    <a href="/salles/<?= (int) $salle->id ?>/edit">Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>