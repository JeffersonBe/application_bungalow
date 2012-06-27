<?php
	//Ce script sert à l'installation du module rentr&eacute;e et notamment de la base de donn&eacute;e.
	include('assets/connect/connect_settings.php');
	include('assets/connect/bungalows.php');

	try
	{
		echo('Test de la connexion..........');
		//On teste la connexion
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
		echo('Connexion r&eacute;ussie');
		//On teste si le module est d&eacute;jà install&eacute;
		echo('<br/>V&eacute;rification du statut du module..........');
		$answer='';
		$query=$bdd->prepare('SHOW TABLES FROM '.$namedb.';');
		$query->execute();
		$flag=1;
		while(($answer=$query->fetch())!=''&&$flag)
		{
			if($answer['Tables_in_'.$namedb]==$secur_table||$answer['Tables_in_'.$namedb]==$nainsa_table||$answer['Tables_in_'.$namedb]==$stats_table)
			{
				$flag=0;
			}
		}
		if($flag)
		{
				echo('non install&eacute;');
				//On installe la table des adh&eacute;rents
				echo('<br/>Cr&eacute;ation de la table des adh&eacute;rents..........');
				$query=$bdd->prepare('CREATE TABLE '.$nainsa_table.' (
				id INT AUTO_INCREMENT PRIMARY KEY,
				prenom TEXT NOT NULL,
				nom TEXT NOT NULL,
				ecole VARCHAR(3) NOT NULL,
				sexe VARCHAR(1) NOT NULL,
				promo VARCHAR(4) NOT NULL,
				s2ia VARCHAR(10),
				email TEXT,
				datenaissance VARCHAR(8),
				lieunaissance TEXT,
				portable VARCHAR(10),
				fixe VARCHAR(10),
				adresse TEXT,
				ficherentree VARCHAR(3),
				cotisantbde VARCHAR(3),
				typepaiementcotiz VARCHAR(11),
				interetsg VARCHAR(3),
				comptesg VARCHAR(3),
				numcompte VARCHAR(23),
				prelevement VARCHAR(3),
				boursier VARCHAR(3),
				pallier VARCHAR(10),
				interetwei VARCHAR(3),
				wei VARCHAR(3),
				tarifwei TEXT,
				prixwei INT,
				tarifbde TEXT,
				prixbde INT,
				typepaiementwei VARCHAR(11),
				caution VARCHAR(3),
				regime TEXT,
				technoparade VARCHAR(3),
				teeshirttechnoparade VARCHAR(3),
				bbqsam VARCHAR(3),
				bbqdim VARCHAR(3),
				bbqven VARCHAR(3),
				bbqmar VARCHAR(3),
				bbqmer VARCHAR(3),
				bbqjeu VARCHAR(3),
				bbqpaye VARCHAR(3),
				etatprelevement TEXT,
				creation DATETIME NOT NULL,
				modification DATETIME NOT NULL,
				clef VARCHAR(50),
				reservationbungalow INT
				) ENGINE = MYISAM ;');
				$query->execute();
				echo('R&eacute;ussie');

				//On installe la table des stats
				echo('<br/>Cr&eacute;ation de la table des stats..........');
				$query=$bdd->prepare('CREATE TABLE '.$stats_table.' (type VARCHAR (15) NOT NULL ,pc_gauche INT NOT NULL , pc_droite INT NOT NULL, nb_gauche INT NOT NULL, nb_droite INT NOT NULL, total INT NOT NULL);');
				$query->execute();
				echo('R&eacute;ussie');

				//On mets à 0 les stats
				echo('<br/>Initialisations des stats..........');
				$query=$bdd->prepare('INSERT INTO '.$stats_table.' (type,pc_gauche, pc_droite, nb_gauche, nb_droite, total) VALUES (:d1,:d2, :d3, :d4, :d5, :d6);');
				$query->execute(array(
				'd1'=>'ecole',
				'd2'=>50,
				'd3'=>50,
				'd4'=>0,
				'd5'=>0,
				'd6'=>0
				));
				$query=$bdd->prepare('INSERT INTO '.$stats_table.' (type,pc_gauche, pc_droite, nb_gauche, nb_droite, total) VALUES (:d1,:d2, :d3, :d4, :d5, :d6);');
				$query->execute(array(
				'd1'=>'sexe',
				'd2'=>50,
				'd3'=>50,
				'd4'=>0,
				'd5'=>0,
				'd6'=>0
				));
				echo('R&eacute;ussie');

				//On met les images de stats en cache
				echo('<br/>Mise en cache des images..........');
				include('includes/img_stat_ecole.php');
				include('includes/img_stat_sexe.php');
				img_stat_ecole(50,0,0);
				img_stat_sexe(50);
				echo('R&eacute;ussie');
				//On installe la table de s&eacute;curit&eacute;

				echo('<br/>Cr&eacute;ation de la table de securit&eacute;..........');
				$query=$bdd->prepare('CREATE TABLE '.$secur_table.' (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,code VARCHAR( 64) NOT NULL) ENGINE = MYISAM ;');
				$query->execute();
				echo('R&eacute;ussie');

				//On installe la table de r&eacute;servation des bungalows
				echo('<br/>Cr&eacute;ation de la table de r&eacute;servation des bungalows..........');
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
				nb_nainsa INT,
				'.$nainsa.') ENGINE = MYISAM ;');
				if($query->execute()){echo('R&eacute;ussie');}

				//On remplit la table de r&eacute;servation des bungalows, on cr&eacute;&eacute; notre petit village de vacances ;-)
				echo('<br/>Cr&eacute;ations des bungalows et des &eacute;quipes wei associ&eacute;es..........');

				// Pour chaque &eacute;quipe:
				for($i=1; $i<=7; $i++)
				{
					//On cr&eacute;&eacute; tous les gros bungalows en les marquant comme vide
					for($j=1;$j<=$equipe_officiel[$i]['big'];$j++)
					{
						$query=$bdd->prepare('INSERT INTO '.$bung_table.' (equipe,contenance, nb_nainsa) VALUES (:equipe,:contenance, :nb_nainsa);');
					$query->execute(array(
					'equipe'=>$i,
					'contenance'=>$big_officiel,
					'nb_nainsa'=>0
					));
					}
					//On cr&eacute;&eacute; tous les petits bungalows en les marquant comme vide
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

				echo('R&eacute;ussie');
				$query->closeCursor();
				// Et voilà c'est fini :-P

				echo('<br/>F&eacute;licitation: l\'installation a eu un succès fou!<br/> Vous pouvez d&eacute;sormais utiliser l\'application rentr&eacute;e en vous connectant via cette page:<a href=\'index.php\'>index.php</a>');
		}
		else
		{
			echo('Module d&eacute;jà install&eacute;.<br/>L\'installation s\'est interrompue car les tables Mysql ont d&eacute;jà &eacute;t&eacute; cr&eacute;es.');
		}

	}
	catch (Exception $e)
	{
	die('Erreur : ' . $e->getMessage().'<br/><br/>Le module rentr&eacute;e n\'est pas correctement configur&eacute;.<br/>Veuillez v&eacute;rifiez les paramètres de connexion au serveur mysql via le fichier connect_settings.php.<br/>Si le probleme persiste, consultez le fichier <a href=\'README.txt\'>README.txt</a>');

	}
?>