<?php


include('../rentree/connect_settings.php');
$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
if((!empty($_GET['c'])&&(!empty($_GET['l']))&&($bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options)))
{
	$clef=addslashes($_GET['c']);
	$id=addslashes($_GET['l']);
	$query=$bdd->prepare('SELECT clef FROM '.$nainsa_table.' WHERE id=:r_id;');
	if($answer=execute(array('r_id'=>$id)))
	{
		$bdd_clef=$answer['clef'];
		if(bdd_clef==$clef)
		{
			$query=$bdd->prepare('UPDATE '.$bung_table.' SET reservationbungalow= :r_reservationbungalow WHERE id=:r_id;');
			if($answer=execute(array('r_reservation_bungalow'=>2,'r_id'=>$id)))
			{
				echo "Ta réservation a bien été confirmée ;-) ";
				$query->closeCursor();
			}
		}
		else
		{
			echo "La clef fournie n'est pas valide";
		}
	}
	else
	{
		echo "Problème de connection à la base de donnée.";
	}
		
}
else
{
	echo "Erreur. Ta réservation n'a pas été confirmée";
	
}

?>