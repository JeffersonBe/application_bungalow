# Application de rentrée version 2012

Ce module de rentrée a été élaboré par Pierre-Edouard MONTABRUN (Hypnoz BDE 2011), en s'inspirant du travail de Romain BRUN (Com'on! BDE 2010) et d'Arnaud BRUSSEAU(Osmoz BDE 2009).

Cette application est un outil interne au BDE, élaboré pour faciliter l'inscription des adhérents.

Sa structure modulaire a été adoptée pour faciliter sa modification donc ne vous en privez pas !

## Instructions d'installation
* Uploader le dossier sur le ftp
* Modifier auth.php pour enregistrer les mots de passe des membre du BDE et du Bureau
* Modifier connect_settings.php pour inscrire les informations concernant le serveur Mysql.
* Modifier le fichier tarifs.php pour définir les prix pour le wei et la cotisation.
* Modifier le fichier bungalows.php pour définir le nombre de bungalows, la couleurs des équipes wei et les tailles des bungalows.
* Lancer install.php pour installer les tables nécessaires dans la bdd

Enjoy!

## Notes d'utilisation

Ce module a été testé sous php5, je n'ai aucune idée de sa réaction avec une version antérieure de php.

En cas de problème, contacter Pierre-Edouard MONTABRUN (pemontabrun@gmail.com)
## Idées d'amélioration>>>>

### 2011:
* Utilisation du ldap de l'école pour rechercher les informations sur l'élève et préremplir la fiche de renseignements.
Commenter le code de façon claire
* Garder les stats d'une année sur l'autre pour pouvoir établir des courbes d'évolutions
* Mise en place d'une meilleur sécurité, avec un login via session mysql(seul le numéro de la session est gardé dans les cookie et les variables sessions, c'est pour cela qu'a été créée la table security).
* Stocker toutes les stats à la manière des stats sexe et écoles pour que la page de stats soit générée bien plus vite.
* Rajouter des vérifications à register.php
* Séparer la modification de la création dans activités récentes.
* Trouver un moyen de suivre la scolarité des cotisants (césure, année jeune ingénieur, prolongation de scolarité) (très utile pour les procurations)
* trouver d'autres améliorations ;-)
* Crypter les ribs (md5)

## Historique des modifications

### 2012
* Refonte du code (indentation, commentaire, gestion des dossiers)

### 2011
* Refonte de l'application pour faciliter sa modification
* Nouveau design
* Ajout d'une vérification de la clef RIB
* Modification légère des textes du formulaire
* Ajout d'un caroussel pour rendre l'inscription des nainsA plus "esthétique"
* Formulaire de prélèvement complètement revue avec des petites options ajax et le téléchargement du fichier texte à la fin.
* Ajout d'entrées  dans la bdd concernant la portable, l'adresse, la date de création et la date d'inscription
* Ajout d'un script de création d'images cache de stats (garçon/fille, tem/tsp)
* Création d'un script d'installation, pour faciliter la mise en place de l'application

## Description des fichiers

### auth.php
Contient la fonction hothentic(), qui permet l'identification de l'utilisateur via SESSION + COOKIE
### compta.php
Contient le formulaire de prélèvement. Nécessite search.php et trez.js lors de son execution.

### connect_settings.php
Contient les informations de connexion à la base de donnée Mysql

### deco.php
Permet la déconnexion de l'utilisateur et renvoie ensuite sur index.php

### etape1.php
Première étape de l'inscription d'un nouveau membre:
* se connecte à la bdd et vérifie s'il existe, si c'est le cas il renvoie une description rapide, un lien pour consulter et un lien pour modifier
* Propose un formulaire avec nom prenom et ecole pour créer une fiche.

### etape2.php
* Gère la modification et la création d'une nouvelle fiche.
* Vérifie la clef RIB en appelant rib.js

### fiche.php
Affiche la fiche d'une personne dont l'id est passé en paramètre $_POST

### img_stat_ecole.php
Contient la fonction qui crée une image de compteur et inscrit le stats TEM et TSP grâce à la table de statistiques. L'image est ensuite enregistrée dans img_cache.

### img_stat_sexe.php
Contient la fonction qui crée une image de compteur et inscrit le stats garçons et filles grâce à la table de statistiques. L'image est ensuite enregistrée dans img_cache.

### index.php
Page d'accueil. En fonction de la réponse de hothentic(), renvoie une page d'authentification ou la page d'accueil de l'application. Le menu contient un lien vers les stats et la compta uniquement si l'utilisateur authentifié est de niveau 2 (bureau)

### install.php
Vérifie que la connexion à la bdd est possible et que le module n'est pas déjà installé. Si c'est le cas, il créé les tables dans la bdd et renvoie un mesage correspondant au statut de l'installation et aux eventuelles erreurs.

### rib.js
* Contient la fonction verif_clef() qui renvoit la validité de la clef sur etape2.php via un systeme de div register.php.
* Enregistre les informations issues du formulaire etape2.php.
* En cas d'erreur, renvoie vers etape2.php avec un message indiquant quelles sont les erreurs.

### search.php
Fournit le résultat de la recherche passée en paramètre $_GET['q']. '_all' renvoie tout le contenu de la table, sinon seul les résultats commençant par $_GET['q'] sont renvoyés sous forme de tableau

### stats.php
Génère des statistiques sur la promo e sur la base de donnée.

### style.css
Feuille de style appelée par tous les fichiers php

### trez.js
Contient un peu d'ajax pour afficher le résultat de la recherche en live (via search.php) et de quoi manipuler les listes d'adhérent à prélever.
En espérant que cette doc facilitera la vie de mes successeurs ;-)