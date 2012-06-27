<?php
	//Ce script sert � l'installation du module rentr�e et notamment de la base de donn�e.
	include('../assets/connect/connect_settings.php');
	include('../assets/connect/bungalows.php');

	try
	{
		echo('Test de la connexion..........');
		//On teste la connexion
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
		echo('Connexion r�ussie');

						echo('<br/>Cr�ation de la table de r�servation des bungalows..........');
				$nainsa='nainsa1 INT DEFAULT 0';
				for($i=2; $i<=$big_officiel; $i++)
				{
					$nainsa=$nainsa.', nainsa'.$i.' INT DEFAULT 0';
				}
				$query=$bdd->prepare('CREATE TABLE '.$bung_table.' (
				id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				equipe INT,
				nom VARCHAR( 64),
				contenance INT,
				numero TEXT,
				nb_nainsa INT,
				'.$nainsa.') ENGINE = MYISAM ;');
				if($query->execute()){echo('R�ussie');}


				//On remplit la table de r�servation des bungalows, on cr�� notre petit village de vacances ;-)
				echo('<br/>Cr�ations des bungalows et des �quipes wei associ�es..........');

				// Pour chaque �quipe:
				for($i=1; $i<=7; $i++)
				{
					//On cr�� tous les gros bungalows en les marquant comme vide
					for($j=1;$j<=$equipe_officiel[$i]['big'];$j++)
					{
						$query=$bdd->prepare('INSERT INTO '.$bung_table.' (equipe,contenance, nb_nainsa) VALUES (:equipe,:contenance, :nb_nainsa);');
					$query->execute(array(
					'equipe'=>$i,
					'contenance'=>$big_officiel,
					'nb_nainsa'=>0
					));
					}
					//On cr�� tous les middle bungalows en les marquant comme vide
					for($j=1;$j<=$equipe_officiel[$i]['middle'];$j++)
					{
						$query=$bdd->prepare('INSERT INTO '.$bung_table.' (equipe,contenance, nb_nainsa) VALUES (:equipe,:contenance, :nb_nainsa);');
					$query->execute(array(
					'equipe'=>$i,
					'contenance'=>$middle_officiel,
					'nb_nainsa'=>0
					));
					}

					//On cr�� tous les petits bungalows en les marquant comme vide
					for($j=1;$j<=$equipe_officiel[$i]['small'];$j++)
					{
						$query=$bdd->prepare('INSERT INTO '.$bung_table.' (equipe,contenance, nb_nainsa) VALUES (:equipe,:contenance, :nb_nainsa);');
					$query->execute(array(
					'equipe'=>$i,
					'contenance'=>$small_officiel,
					'nb_nainsa'=>0
					));
					}
				}

				echo('R�ussie');
				$query->closeCursor();
				// Et voil� c'est fini :-P

				echo('<br/>F�licitation: l\'installation a eu un succ�s fou!<br/> Vous pouvez d�sormais utiliser l\'application rentr�e en vous connectant via cette page:<a href=\'index.php\'>index.php</a>');


	}
	catch (Exception $e)
	{
	die('Erreur : ' . $e->getMessage().'<br/><br/>Le module rentr�e n\'est pas correctement configur�.<br/>Veuillez v�rifiez les param�tres de connexion au serveur mysql via le fichier connect_settings.php.<br/>Si le probleme persiste, consultez le fichier <a href=\'README.txt\'>README.txt</a>');

	}
?>