# Ibrahim_Nidam_Project

**Gestionnaire de Projets (OOP)**

**Author du Brief:** Iliass RAIHANI.

**Author:** Ibrahim Nidam.

## Links

- **GitHub Repository :** [View on GitHub](https://github.com/Youcode-Classe-E-2024-2025/Ibrahim_Nidam_Project.git)
- **Backlog Link :** [View Backlog](https://github.com/orgs/Youcode-Classe-E-2024-2025/projects/90/views/1?layout=board)
- **UML Link :** [View UML](https://lucid.app/lucidchart/8cfe8452-d748-4503-ab8b-835080a36dcc/edit?viewport_loc=-333%2C121%2C1809%2C836%2CHWEp-vi-RSFO&invitationId=inv_0eb92c3b-b340-4c27-aaaf-803b6052a83b)

### Créé : 30/12/24

La plateforme vise à faciliter la gestion et la collaboration des équipes en offrant aux utilisateurs un espace pour créer, suivre, et gérer leurs projets.


# Configuration et Exécution du Projet

### Prérequis
* **Node.js** et **npm** installés (téléchargez [Node.js](https://nodejs.org/)).
* **Laragon** installé (téléchargez [Laragon](https://laragon.org/download/)).
* **PHP** installé et ajouté au PATH (Environnement système).

### Étapes d’installation

1. **Cloner le projet** :
   - Ouvrir un terminal et exécuter :  
     `git clone https://github.com/Youcode-Classe-E-2024-2025/Ibrahim_Nidam_Project.git`

2. **Placer le projet dans le dossier Laragon** :
   - Cliquez sur le bouton **Root** dans Laragon pour ouvrir le dossier `www` (par défaut, `C:\laragon\www`).
   - Le chemin de votre projet devrait être `C:\laragon\www\Ibrahim_Nidam_Project`.

3. **Configurer la base de données** :
   - Faites un clic droit sur **Laragon**, puis allez dans **Tools** > **Quick Add** et téléchargez **phpMyAdmin** et **MySQL**.
   - Ouvrir **phpMyAdmin** via Laragon :
     - Dans Laragon, cliquez sur le bouton **Database** pour accéder à phpMyAdmin (username = `root` et mot de passe est vide).
     - Créez une base de données `Kanban_Project_db` et importez le fichier `script.sql` (disponible dans le dossier `/database/`).

4. **Installer les dépendances Node.js** :
   - Ouvrez un terminal dans le dossier du projet cloné.
   - Exécutez :  `npm install` ou `npm i`

5. **Installer Composer** :
   - Ouvrez un terminal dans le dossier du projet cloné et exécutez les commandes suivantes :

     ```cmd
     REM Télécharger l'installateur Composer
     php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

     REM Vérifier le hash SHA-384 de l'installateur
     php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') echo Installer verified && exit; echo Installer corrupt && del composer-setup.php && exit /b 1"

     REM Exécuter l'installateur
     php composer-setup.php

     REM Supprimer le script d'installation
     php -r "unlink('composer-setup.php');"

     REM Déplacer composer.phar dans un répertoire du PATH (optionnel pour un usage global)
     move composer.phar C:\bin\composer.phar
     ```

    - Ajoutez le dossier `C:\bin` à votre variable d'environnement PATH pour utiliser Composer globalement.

6. **Initialiser Composer dans le projet** :
   - Dans le dossier racine du projet, exécutez :

     ```cmd
     composer init
     ```
   - Suivez les instructions pour générer un fichier `composer.json` et accepter **psr-4**.

7. **Installer les dépendances PHP** :
   - Une fois le fichier `composer.json` généré, installez les dépendances en exécutant :

     ```cmd
     composer install
     ```

8. **Configurer Laragon pour le serveur local** :
   - Lancez **Laragon** et démarrez les services **Apache** et **MySQL** en cliquant sur **Start All**.

9. **Exécuter le projet** :
   - Une fois les services lancés dans Laragon, cliquez sur le bouton **Web** pour accéder à `http://localhost/Ibrahim_Nidam_Project` dans votre navigateur.



## **Contexte du projet:**

Afin de mieux gérer le travail de l'entreprise le CTO vous demande de fournir une interface intuitive pour les membres des équipes, ainsi qu’un tableau de bord pour les chefs de projet, permettant une gestion efficace des tâches, des membres, et des échéances.

L'objectif est de créer un environnement où les membres d’équipes peuvent collaborer, suivre les progrès des projets, et atteindre leurs objectifs dans les délais impartis, tout en utilisant des outils performants et ergonomiques.

​

**Technologies Requises**

- Langage : PHP 8 (Programmation Orientée Objet).
- Base de Données : PDO comme driver pour interagir avec la base de données.


​

## Fonctionnalités principales

​
**En tant que chef de projet :** 

Gestion des projets :
- Je veux pouvoir créer, modifier, et supprimer des projets pour structurer le travail de l’équipe.

​

Gestion des tâches :

- Je veux assigner des tâches aux membres pour une meilleure répartition des responsabilités.
- Catégoriser mes tâche en gérant des catégories.
    Tager mes tâche en gérant des tags.

​

Suivi de l’avancement :

- Je souhaite consulter l’état des tâches pour m'assurer que le projet avance comme prévu.

​

**En tant que membre d’équipe :**

Inscription et connexion :

- Je veux pouvoir m’inscrire avec mon nom, mon e-mail et un mot de passe pour accéder à mon compte.
- Je souhaite me connecter de manière sécurisée pour consulter et mettre à jour mes tâches.

​

Participation aux projets :

- Je veux accéder aux projets auxquels je suis assigné pour consulter les tâches et échéances.
- Je souhaite mettre à jour le statut de mes tâches pour informer l’équipe de mon avancement.

​

**En tant qu’utilisateur invité :**

- Je veux pouvoir visualiser les projets publics pour découvrir les activités des équipes.

- Je souhaite m’inscrire si je décide de rejoindre une équipe ou créer mes propres projets.




## **Modalités pédagogiques**

**Version 1 :**

    Travail : individuel
    Durée de travail : 5 jours
    Date de lancement du brief : 30/12/2024 à 09:00
    Date limite de soumission : 03/01/2025 avant 23:59

​

**Version 2 (Disponible le 6 Janvier) :**

    Travail : individuel
    Durée de travail : 5 jours
    Date de lancement du brief : 06/01/2025 à 09:00
    Date limite de soumission : 10/01/2025 avant 23:59

#### NB : Notez que tout livrable incomplet causera l'invalidation de l'ensemble des compétences.


## **Modalités d'évaluation**

- 30 minutes : Quiz avec mise en situation.
- 15 minutes : Démonstration et code review.

## **Livrables**

- Lien du repository GitHub du projet (Code source + script SQL) sous le nom "prenom_nom-project".
- La gestion des tâches sur un Scrum Board avec toutes les User Stories.
- Les diagrammes UML :
   * Diagramme de classes.
   * Diagramme de cas d'utilisation.

## **Critères de performance**

Planification des tâches : Utilisation d’un outil de gestion comme Jira pour planifier et suivre les tâches.

Elaboration des User Stories : Rédaction claire et précise pour comprendre les besoins.

Commits journaliers : Fournir des commits réguliers sur GitHub pour un meilleur suivi des modifications.

Design responsive : Interface adaptée à tous les types d’écrans grâce à un framework CSS.

Validation des formulaires :
- Validation Frontale : HTML5 et JavaScript pour minimiser les erreurs utilisateur.
- Validation Backend : Mesures de sécurité contre XSS et CSRF.

Structure du projet : Séparation claire de la logique métier et de l’architecture.
Sécurité :
- Prévention des injections SQL avec des requêtes préparées.
- Protection contre le XSS en échappant les données affichées.
- Gestion des erreurs avec une page 404 dédiée.