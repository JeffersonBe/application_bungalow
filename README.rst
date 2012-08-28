Application de rentrée BDE Showtime 2012.

Auteurs
=======

* Jefferson BONNAIRE, jefferson.bonnaire@showtime2012.fr
  Respo Web Showtime 2012
* Anthony VEREZ, netantho@minet.net
  Président de MiNET 2012-2013

TODO
====

* Statistiques
** Cotisants / Non cotisants
** Boursier / Non boursier
** Images / Graphs ~Temps réel
* Couleurs pour les équipes
* Vérification de la clé de RIB
* Pagination au niveau des vues ?
* Tests pour modèle Log

Dans le code, chercher FIXME, TODO, @todo, @fixme

Installation
===========

1. Mettre sa clé SSH sur BitBucket : https://confluence.atlassian.com/display/BITBUCKET/Set+up+SSH+for+Git
2. Installer le logiciel git : https://confluence.atlassian.com/display/BITBUCKET/Set+up+Git+and+Mercurial
3. $ git clone git@bitbucket.org:bdeshowtime2012/application_bungalow.git
4. Créer une base de données mysql (avec phpmyadmin par exemple)
5. Modifier application/config/database.php avec les informations de la base de données
6. À la ligne 251 de application/config/config.php, remplacer 'TRUE' par 'FALSE'
7. Dans votre navigateur, aller à la page monsite.com/migration en adaptant monsite.com ^^
8. À la ligne 251 de application/config/config.php, remplacer 'FALSE' par 'TRUE'
9. $ chmod 777 application/logs application/cache
10. Adapter la ligne 3 de .htaccess en précisant le chemin de l'application à partir de localhost/


Mise en production
==================

Idem + les étapes suivantes

1. À la ligne 21 de index.php, remplacer 'development' par 'production'
2. À la ligne 183 de application/config/config.php, remplacer "$config['log_threshold'] = 4;" par "$config['log_threshold'] = 1;"

Documentation
=============

* La documentation de CodeIgniter est dans le répertoire user_guide
* Pour générer la documentation de l'application :
    1. Installer doxygen http://www.stack.nl/~dimitri/doxygen/
    2. Dans $ cd doc ; doxygen config
    3. Regarder la doc générée dans doc/html