<?php
	//Ce script sert à l'installation du module rentrée et notamment de la base de donnée.
	include('../assets/connect/connect_settings.php');
	include('../assets/connect/bungalows.php');

	try
	{
		echo('Test de la connexion..........');
		//On teste la connexion
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
		echo('Connexion réussie');

						echo('<br/>Création de la table de réservation des bungalows..........');
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
				if($query->execute()){echo('Réussie');}


				//On remplit la table de réservation des bungalows, on créé notre petit village de vacances ;-)
				echo('<br/>Créations des bungalows et des équipes wei associées..........');

				// Pour chaque équipe:
				for($i=1; $i<=7; $i++)
				{
					//On créé tous les gros bungalows en les marquant comme vide
					for($j=1;$j<=$equipe_officiel[$i]['big'];$j++)
					{
						$query=$bdd->prepare('INSERT INTO '.$bung_table.' (equipe,contenance, nb_nainsa) VALUES (:equipe,:contenance, :nb_nainsa);');
					$query->execute(array(
					'equipe'=>$i,
					'contenance'=>$big_officiel,
					'nb_nainsa'=>0
					));
					}
					//On créé tous les middle bungalows en les marquant comme vide
					for($j=1;$j<=$equipe_officiel[$i]['middle'];$j++)
					{
						$query=$bdd->prepare('INSERT INTO '.$bung_table.' (equipe,contenance, nb_nainsa) VALUES (:equipe,:contenance, :nb_nainsa);');
					$query->execute(array(
					'equipe'=>$i,
					'contenance'=>$middle_officiel,
					'nb_nainsa'=>0
					));
					}

					//On créé tous les petits bungalows en les marquant comme vide
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

				echo('Réussie');
				$query->closeCursor();
				// Et voilà c'est fini :-P

				echo('<br/>Félicitation: l\'installation a eu un succès fou!<br/> Vous pouvez désormais utiliser l\'application rentrée en vous connectant via cette page:<a href=\'index.php\'>index.php</a>');


	}
	catch (Exception $e)
	{
	die('Erreur : ' . $e->getMessage().'<br/><br/>Le module rentrée n\'est pas correctement configuré.<br/>Veuillez vérifiez les paramètres de connexion au serveur mysql via le fichier connect_settings.php.<br/>Si le probleme persiste, consultez le fichier <a href=\'README.txt\'>README.txt</a>');

	}
?>