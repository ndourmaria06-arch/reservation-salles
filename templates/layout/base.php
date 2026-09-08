<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre ?? 'Réservation de salles', ENT_QUOTES) ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="/">Accueil</a>
            <a href="/salles">Salles</a>
            <a href="/reservations">Réservations</a>
        </nav>
    </header>

    <main>
        <?php if (!empty($messageSucces)): ?>
            <p class="alert alert-succes"><?= htmlspecialchars($messageSucces, ENT_QUOTES) ?></p>
        <?php endif; ?>

        <?= $contenu ?? '' ?>
    </main>
</body>
</html>