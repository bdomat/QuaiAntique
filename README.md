# QuaiAntique

QuaiAntique est une application web pour la gestion d'un site de restaurant. 
Cette application a été développée avec le framework Symfony version 6.2.9.

## Prérequis

Pour exécuter cette application en local, vous aurez besoin de :

- Git
- PHP 8.1.0 ou supérieur
- Composer
- Symfony CLI
- Un système de gestion de bases de données comme MySQL

## Installation

Suivez ces étapes pour installer et exécuter le projet en local :

1. Cloner le dépôt :
git clone https://github.com/bdomat/QuaiAntique.git

2. Aller dans le répertoire du projet :
cd QuaiAntique

3. Installer les dépendances avec Composer :
composer install

4. Configurer votre environnement local en modifiant le fichier `.env` ou en créant un fichier `.env.local` :
 - Définissez la variable `DATABASE_URL` avec les informations de connexion à la base de données
 
5. Créer la base de données :
php bin/console doctrine:database:create

6. Exécuter les migrations pour créer les tables dans la base de données :
php bin/console doctrine:migrations:migrate

7. Lancer l'application en local avec Symfony :
symfony server:start


## Création d'un compte administrateur local

Cette application contient une fixture qui facilite la création d'un compte administrateur. 

Suivez ces étapes pour créer un compte administrateur :

1. Assurez-vous que l'application est bien installée et que la base de données est créée.
2. Ouvrez le fichier `src/DataFixtures/UserFixtures.php`. Ce fichier contient un script pour la création d'un compte utilisateur avec le rôle d'administrateur.
3. Dans ce fichier, vous pouvez modifier l'email et le mot de passe de l'administrateur. Par défaut, l'email est `admin@example.com` et le mot de passe est `password`.
4. Enregistrez vos modifications et exécutez la fixture avec la commande suivante :
php bin/console doctrine:fixtures:load
Cette commande va créer un nouvel utilisateur avec les détails que vous avez spécifiés dans le fichier `UserFixtures.php`.
5. Vous pouvez maintenant vous connecter à l'application avec ce compte administrateur. Allez à `http://localhost:8000/admin` et utilisez l'email et le mot de passe que vous avez définis.

Veuillez noter que l'exécution de cette fixture va supprimer toutes les données existantes dans votre base de données et les remplacer par les données définies dans vos fixtures. Si vous ne voulez pas perdre vos données actuelles, assurez-vous de faire une sauvegarde de votre base de données avant d'exécuter cette commande.

