 o�. Application de rentr�e version 2012 .�o

Ce module de rentr�e a �t� �labor� par Pierre-Edouard MONTABRUN (Hypnoz BDE 2011),
 en s'inspirant du travail de Romain BRUN (Com'on! BDE 2010) et d'Arnaud BRUSSEAU(Osmoz BDE 2009).
 
 Cette application est un outil interne au BDE, �labor� pour faciliter l'inscription des adh�rents.
 Sa structure modulaire a �t� adopt�e pour faciliter sa modification donc ne vous en privez pas!
 
 
<<<< Instructions d'installation>>>>
 -Uploader le dossier sur le ftp
 -Modifier auth.php pour enregistrer les mots de passe des membre du BDE et du Bureau
 -Modifier connect_settings.php pour inscrire les informations concernant le serveur Mysql.
 -Modifier le fichier tarifs.php pour d�finir les prix pour le wei et la cotisation.
 -Modifier le fichier bungalows.php pour d�finir le nombre de bungalows, la couleurs des �quipes wei et les tailles des bungalows.
 -Lancer install.php pour installer les tables n�cessaires dans la bdd
 -Enjoy!
 
<<<< Notes d'utilisation>>>>
 Ce module a �t� test� sous php5, je n'ai aucune id�e de sa r�action avec une version ant�rieure de php.
 En cas de probl�me, contacter Pierre-Edouard MONTABRUN (pemontabrun@gmail.com)
 
<<<< Id�es d'am�lioration>>>>

2011:
 -Utilisation du ldap de l'�cole pour rechercher les informations sur l'�l�ve et pr�remplir
 la fiche de renseignements.
 -Commenter le code de fa�on claire
 -Garder les stats d'une ann�e sur l'autre pour pouvoir �tablir des courbes d'�volutions
 -Mise en place d'une meilleur s�curit�, avec un login via session mysql
 (seul le num�ro de la session est gard� dans les cookie et les variables sessions, c'est pour cela qu'a �t� cr��e la table security).
 - Stocker toutes les stats � la mani�re des stats sexe et �coles pour que la page de stats soit g�n�r�e bien plus vite.
 - Rajouter des v�rifications � register.php
 -S�parer la modification de la cr�ation dans activit�s r�centes
 -Trouver un moyen de suivre la scolarit� des cotisants (c�sure, ann�e jeune ing�nieur, prolongation de scolrit�)
  (tr�s utile pour les procurations)
 -trouver d'autres am�liorations ;-)
 -crypter les ribs (md5)
 
 
<<<<Historique des modifications>>>>

2012:
	- Refonte du code (indentation, commentaire, gestion des dossiers)

2011:
	-Refonte de l'application pour faciliter sa modification
	-nouveau design
	-Ajout d'une v�rification de la clef RIB
	-Modification l�g�re des textes du formulaire
	-Ajout d'un caroussel pour rendre l'inscription des nainsA plus "esth�tique"
	-Formulaire de pr�l�vement compl�tement revue avec des petites options ajax et le t�l�chargement du fichier texte � la fin.
	-Ajout d'entr�es  dans la bdd concernant la portable, l'adresse, la date de cr�ation
	et la date d'inscription
	-Ajout d'un script de cr�ation d'images cache de stats (gar�on/fille, tem/tsp)
	-Cr�ation d'un script d'installation, pour faciliter la mise en place de l'application

<<<<Description des fichiers>>>>

auth.php
	Contient la fonction hothentic(), qui permet l'identification de l'utilisateur via SESSION + COOKIE
	
compta.php
	Contient le formulaire de pr�l�vement. N�cessite search.php et trez.js lors de son execution.

connect_settings.php
	Contient les informations de connexion � la base de donn�e Mysql
	
deco.php
	Permet la d�connexion de l'utilisateur et renvoie ensuite sur index.php
	
etape1.php
	Premi�re �tape de l'inscription d'un nouveau membre:
		-se connecte � la bdd et v�rifie s'il existe, si c'est le cas il renvoie une description rapide,
		 un lien pour consulter et un lien pour modifier
		-Propose un formulaire avec nom prenom et ecole pour cr�er une fiche.
		
etape2.php
	G�re la modification et la cr�ation d'une nouvelle fiche.
	V�rifie la clef RIB en appelant rib.js
	
fiche.php
	Affiche la fiche d'une personne dont l'id est pass� en param�tre $_POST
			
img_stat_ecole.php
	Contient la fonction    qui cr�e une image de compteur et inscrit le stats TEM et TSP
	gr�ce � la table de statistiques. L'image est ensuite enregistr�e dans img_cache.

img_stat_sexe.php
	Contient la fonction    qui cr�e une image de compteur et inscrit le stats gar�ons et filles
	gr�ce � la table de statistiques. L'image est ensuite enregistr�e dans img_cache.
	
index.php
	Page d'accueil. En fonction de la r�ponse de hothentic(), renvoie une page d'authentification
	ou la page d'accueil de l'application. Le menu contient un lien vers les stats et la compta uniquement
	si l'utilisateur authentifi� est de niveau 2 (bureau)
	
install.php
	V�rifie que la connexion � la bdd est possible et que le module n'est pas d�j� install�.
	Si c'est le cas, il cr�� les tables dans la bdd et renvoie un mesage correspondant au statut
	de l'installation et aux eventuelles erreurs

rib.js
	Contient la fonction verif_clef() qui renvoit la validit� de la clef sur etape2.php
	via un systeme de div 

register.php
	Enregistre les informations issues du formulaire etape2.php.
	En cas d'erreur, renvoie vers etape2.php avec un message indiquant quelles sont les erreurs
	
search.php
	Fournit le r�sultat de la recherche pass�e en param�tre $_GET['q']. '_all' renvoie tout le
	contenu de la table, sinon seul les r�sultats commen�ant par $_GET['q'] sont renvoy�s sous
	forme de tableau
	
stats.php
	G�n�re des statistiques sur la promo e sur la base de donn�e.
	
style.css
	Feuille de style appel�e par tous les fichiers php
	
trez.js
	COntient un peu d'ajax pour afficher le r�sultat de la recherche en live (via search.php) et de quoi manipuler les listes d'adh�rent � pr�lever.
	
	
En esp�rant que cette doc facilitera la vie de mes successeurs ;-)