# GestionDemandes

**GestionDemandes** est une application web qui permet de gérer efficacement les demandes de ressources matérielles ou logicielles au sein d’une startup ou d’une PME.  

Cette plateforme modernise l’approche traditionnelle des demandes (emails envoyés aux responsables ou formulaires papier) en offrant :  
- Une interface centralisée pour créer et suivre les demandes.  
- Un système de validation et de suivi automatisé.  
- Une gestion claire des ressources disponibles.  
- Des notifications pour informer les utilisateurs de l’avancement de leurs demandes.  

---

## Technologies utilisées

- **Back-end :** Laravel (PHP)  
- **Front-end :** Blade  
- **Base de données :** MySQL  

---

## Installation et configuration complètes

Suivez ces étapes pour installer et lancer l’application sur votre machine locale :

1. **Cloner le dépôt :**
```bash
git clone https://github.com/essoygeo/GestionDemandes.git
cd GestionDemandes

    Installer les dépendances PHP et Node.js :

composer install
npm install

    Créer le fichier d’environnement et configurer la base de données :

cp .env.example .env

    Modifier les paramètres de la base de données dans .env :

DB_DATABASE=nom_de_la_base
DB_USERNAME=ton_utilisateur
DB_PASSWORD=ton_mot_de_passe

    Générer la clé de l’application Laravel :

php artisan key:generate

    Migrer la base de données :

php artisan migrate

    Compiler les assets front-end :

npm run dev

    Lancer le serveur de développement :

php artisan serve
