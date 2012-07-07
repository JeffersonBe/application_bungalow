Application de rentrée BDE Showtime 2012.

Auteurs
=======

* Jefferson BONNAIRE, jefferson.bonnaire@showtime2012.fr
  Respo Web Showtime 2012
* Anthony VEREZ netantho@minet.net
  Président de MiNET 2012-2013


Installation
===========

1. Mettre sa clé SSH sur BitBucket : https://confluence.atlassian.com/display/BITBUCKET/Set+up+SSH+for+Git
2. Installer le logiciel git : https://confluence.atlassian.com/display/BITBUCKET/Set+up+Git+and+Mercurial
3. $ git clone git@bitbucket.org:bdeshowtime2012/application_bungalow.git
4. Créer une base de données mysql (avec phpmyadmin par exemple)
5. Modifier application/config/database.php avec les informations de la base de données
6. Importer le fichier db.sql dans la base de données mysql (avec phpmyadmin par exemple)
7. $ chmod 777 application/logs application/cache


Documentation
=============

* La documentation de CodeIgniter est dans le répertoire user_guide
* Pour générer la documentation de l'application :
    1. Installer doxygen http://www.stack.nl/~dimitri/doxygen/
    2. Dans $ cd doc ; doxygen config
    3. Regarder la doc générée dans doc/html