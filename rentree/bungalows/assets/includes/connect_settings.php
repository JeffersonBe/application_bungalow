<?php
	//Voici le fichier de configuration mysql
		
	$hostdb='localhost';//adresse du serveur mysql
	$logindb='root';//nom d'utilisateur
	$passworddb='root';//mot de passe
	$namedb='rentree';//nom de la base de donn�e
	
	//Nom des tables (vous pouvez tr�s bien laisser par d�faut):
	
	$nainsa_table='nainsa';//nom de la table pour l'inscription des adh�rents
	$stats_table='stats';//Nom de la table pour le calcul des stats
	$secur_table='security';//Nom de la table pour la s�curisation des connexions...inutilis�e pour l'instant
	$bung_table='bungalows';//Nom de la table pour la r�servation des bungalows
	$ldap_table='Feuil1';//Nom de la table pour la copie du ldap de l'�cole
?>