# Réservation de salles universitaires

Application web de gestion des salles et de leurs réservations, développée en PHP orienté
objet sans framework complet (routeur, ORM, validation et conteneur d'injection installés
via Composer).

Réponses aux questions de l’étape 1
# 1. Quel est le rôle de Composer ?
Composer est un gestionnaire de dépendances PHP. Il permet d’installer, mettre à jour et charger automatiquement les bibliothèques nécessaires au projet.

# 2. Différence entre require et require-dev ?
require : dépendances nécessaires au fonctionnement de l’application en production
require-dev : dépendances utiles uniquement pendant le développement/tests (tests, outils, etc.)

# 3. Pourquoi versionner composer.lock ?
Parce que cela verrouille les versions exactes des dépendances installées, ce qui garantit que tout le monde a le même environnement de travail et évite les écarts entre machines.

# 4. Pourquoi ne versionne-t-on pas vendor/ ?
Parce que vendor est généré automatiquement à partir de composer.json et composer.lock. Il est inutile et lourd à versionner, et il peut être recréé à tout moment avec composer install.


Réponses aux questions de l’étape 2
# 1. Quel est le rôle de Composer ?
Composer est le gestionnaire de dépendances de PHP.
Il permet de :installer des bibliothèques PHP ,gérer leurs versions ,installer automatiquement leurs dépendances ,charger automatiquement les classes grâce à l’autoloading.

# 2. Quelle différence existe entre require et require-dev ?
require contient les dépendances nécessaires au fonctionnement de l'application.
require-dev contient les dépendances utilisées uniquement pendant le développement, par exemple pour les tests.

# 3. Pourquoi faut-il versionner composer.lock ?
composer.lock contient les versions exactes des dépendances installées , permet à un autre développeur ou au serveur d'installer exactement les mêmes versions.

# 4. Pourquoi ne versionne-t-on pas vendor/ ?

Le dossier vendor/ contient toutes les bibliothèques installées par Composer.

Il peut être très volumineux et surtout, il peut être recréé automatiquement
