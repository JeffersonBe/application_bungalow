<?php
	//Voici le fichier de configuration mysql
		
	$hostdb='localhost';//adresse du serveur mysql
	$logindb='root';//nom d'utilisateur
	$passworddb='root';//mot de passe
	$namedb='rentree';//nom de la base de donnée
	
	//Nom des tables (vous pouvez très bien laisser par défaut):
	
	$nainsa_table='nainsa';//nom de la table pour l'inscription des adhérents
	$stats_table='stats';//Nom de la table pour le calcul des stats
	$secur_table='security';//Nom de la table pour la sécurisation des connexions...inutilisée pour l'instant
	$bung_table='bungalows';//Nom de la table pour la réservation des bungalows
	$ldap_table='Feuil1';//Nom de la table pour la copie du ldap de l'école
?>