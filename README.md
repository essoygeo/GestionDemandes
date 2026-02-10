Fonctionnalités

Gestion des utilisateurs et rôles : employé, comptable, directeur/admin.

Création et suivi des demandes : ajout de ressources, suivi du statut (en attente, validée, refusée).

Gestion de la caisse : mise à jour automatique selon les demandes validées, suivi des dépenses et justificatifs.

Notifications : alertes pour validation, refus ou modification de demandes.

Historique et statistiques : suivi complet des activités et rapports sur la caisse et les demandes.

Sécurité : authentification, gestion des rôles et permissions.


Installation

1.Cloner le dépôt :
git clone https://github.com/essoygeo/GestionDemandes.git
2.Installer les dépendances :
composer install
3.Configurer .env pour la connexion à la base de données.
4.Lancer les migrations et seeders :
php artisan migrate --seed


