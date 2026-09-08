<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre ?? 'Réservation de salles', ENT_QUOTES) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container site-header-inner">
            <a href="/" class="site-title">Réservation de salles</a>
            <nav class="site-nav">
                <a href="/salles">Salles</a>
                <a href="/reservations">Réservations</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <?php if (!empty($messageSucces)): ?>
            <p class="alert alert-succes"><?= htmlspecialchars($messageSucces, ENT_QUOTES) ?></p>
        <?php endif; ?>

        <?= $contenu ?? '' ?>
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>Université — Gestion des réservations de salles</p>
        </div>
    </footer>
</body>
</html>