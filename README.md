# Planify - Système de Gestion de Projet (Laravel)

Planify est une plateforme de gestion de projet collaborative inspirée de Jira. Elle permet de gérer des équipes, des projets (Kanban) et des tâches avec une gestion précise des rôles (Admin/Membre).

## 🚀 Installation

Suivez ces étapes pour lancer le projet localement :

1.  **Extraire le dossier** et ouvrir un terminal à la racine.
2.  **Installer les dépendances PHP** :
    ```bash
    composer install
    ```
3.  **Configurer l'environnement** :
    - Copiez le fichier `.env.example` vers `.env`.
    - Configurez vos accès à la base de données dans le fichier `.env`.
4.  **Générer la clé d'application** :
    ```bash
    php artisan key:generate
    ```
5.  **Lancer les migrations et les données de test** :
    ```bash
    php artisan migrate --seed
    php artisan db:seed --class=DummyDataSeeder
    php artisan db:seed --class=GhizlaneProjectsSeeder
    ```
6.  **Créer le lien symbolique pour les images** :
    ```bash
    php artisan storage:link
    ```
7.  **Lancer le serveur** :
    ```bash
    php artisan serve
    ```

---

## 👥 Comptes de Test

Voici les identifiants pour tester les différents rôles de l'application.  
**Mot de passe commun pour tous les comptes :** `password123`

| Rôle | Nom | E-mail |
| :--- | :--- | :--- |
| **Administrateur** | Ghizlane | `admin2@test.com` |
| **Administrateur** | Admin User | `admin@test.com` |
| **Membre** | Alice Martin | `alice@test.com` |
| **Membre** | Jean Dupont | `jean@test.com` |
| **Membre** | Kenza | `kenza_po@test.com` |

---

## 🛠️ Fonctionnalités implémentées
- **Dashboard** : Statistiques et graphiques d'avancement (Chart.js).
- **Kanban Board** : Gestion visuelle des tâches par statut.
- **i18n** : Application entièrement bilingue (Français/Anglais).
- **Profils** : Gestion complète des avatars, titres de postes, bios et localisations.
- **Sécurité** : Matrice de permissions stricte entre Admins et Membres.
