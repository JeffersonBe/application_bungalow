<?php

 
function mail_utf8($to, $subject, $message, $header) 
{
  $header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";
  mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header_ . $header);
}
 

include('../rentree/connect_settings.php');
include('../rentree/bungalows.php');

//Sécurisation des variables postées
$id=addslashes($_POST['id_eleve']);
$bungalow=addslashes($_POST['bungalow']);
if(!empty($_POST[$bungalow])){$nom_bungalow=addslashes($_POST[$bungalow]);}else{$nom_bungalow='';}

//Connexion à la bdd
$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);




//Traitement des noms et prénoms

$nom_raw = addslashes($_POST['nom']);
//Parsing du nom
$find = array('à','â','ä','é','è','ê','ë','î','ï','ç','ù','ü','ô','ö');
$replace = array('a','a','a','e','e','e','e','i','i','c','u','u','o','o');
$nom = strtoupper(str_replace($find,$replace,strtolower($nom_raw)));
$prenom_raw = addslashes($_POST['prenom']);
//parsing du prenom
$prenom = strtolower(str_replace($find,$replace,$prenom_raw));

//On vérifie si l'utilisateur est bien inscrit dans la base de donnée
$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE id=:r_id;');
//connexion...
if($answer=$query->execute(array('r_id'=>$id)))
{	//Si on a une réponse...
	if($answer=$query->fetch())
	{
		//Petite vérification du nom au cas où un petit malin envoyait des ids à la pelle
		if(($answer['nom']==$nom)&&($answer['prenom']==$prenom)&&($answer['reservationbungalow']!=2))
		{
			$flag=1;
			//On stocke deux trois infos utiles au passage pour éviter d'y revenir
			$email=$answer['email'];
			$reservation=$answer['reservationbungalow'];
		}
		else
		{
			$flag=0;
		}
	}
	else
	{
		$flag=0;
	}
}
else
{
	$flag=0;
}

//Si on a réussi les testes précedents, alors on choppe le bungalow choisi
$query=$bdd->prepare('SELECT * FROM '.$bung_table.' WHERE id=:r_id;');
if($answer=$query->execute(array('r_id'=>$bungalow))&&$flag)
{
	//On vérifie qu'il est libre
	if(($answer=$query->fetch())&&($answer['nb_nainsa']<$answer['contenance']))
	{	
		//Si l'utilisateur avait déjà réservé son bungalow, on efface sa réservation
		if($reservation==1)
		{
			$query2=$bdd->prepare('SELECT * FROM '.$bung_table.' WHERE nainsa1=:r_id OR nainsa2=:r_id OR nainsa3=:r_id OR nainsa4=:r_id OR nainsa5=:r_id OR nainsa6=:r_id;');
			$answer2=$query2->execute(array('r_id'=>$id));
			if($answer2=$query2->fetch())
			{
				//un beau petit switch pour trouver la position de l'utilisateur dans le bungalow
				switch($id)
				{
					case $answer2['nainsa1']:
						$select=1;
						break;
					case $answer2['nainsa2']:
						$select=2;
						break;
					case $answer2['nainsa3']:
						$select=3;
						break;
					case $answer2['nainsa4']:
						$select=4;
						break;
					case $answer2['nainsa5']:
						$select=5;
						break;
					case $answer2['nainsa6']:
						$select=6;
						break;
				}
				//on supprime toute trace de ce nain a
				for($k=$select;$k<=$big_officiel-1;$k++)
				{
					$answer2['nainsa'.$k]=$answer2['nainsa'.$k];
				}
				$answer2['nainsa'.$big_officiel]=0;
				$answer2['nb_nainsa']=$answer2['nb_nainsa']-1;
				$query2=$bdd->prepare('UPDATE '.$bung_table.' SET nainsa1=:r_nainsa1, nainsa2=:r_nainsa2, nainsa3=:r_nainsa3, nainsa4=:r_nainsa4, nainsa5=:r_nainsa5, nainsa6=:r_nainsa6, nb_nainsa=:r_nb_nainsa WHERE id=:r_id;');
				$answer2=$query2->execute(array(
				'r_nainsa1'=>$answer2['nainsa1'],
				'r_nainsa2'=>$answer2['nainsa2'],
				'r_nainsa3'=>$answer2['nainsa3'],
				'r_nainsa4'=>$answer2['nainsa4'],
				'r_nainsa5'=>$answer2['nainsa5'],
				'r_nainsa6'=>$answer2['nainsa6'],
				'r_id'=>$answer2['id'],
				'r_nb_nainsa'=>$answer2['nb_nainsa']
				));
			}
			else
			{
			$flag=0;
			}
		}
		//On stocke la couleur et on met à jour le nouveau nombre de nainsa dans ce bungalow
		$couleur=$equipe_officiel[$answer['equipe']]['couleur'];
		$new_nbnainsa=$answer['nb_nainsa']+1;
		//On met à jour
		if(empty($answer['nom']))
		{
			// (cas où un nom n'a pas été donné à ce bungalow)
			$query=$bdd->prepare('UPDATE '.$bung_table.' SET nb_nainsa=:r_nb_nainsa, nom=:r_nom, nainsa'.$new_nbnainsa.'=:r_naina WHERE id=:r_id;');
			if($answer=$query->execute(array(':r_nom'=>$nom_bungalow, ':r_nb_nainsa'=>$new_nbnainsa,':r_naina'=>$id, ':r_id'=>$bungalow))){$flag=1;}else{$flag=0;};
		}
		else
		{	
			// (cas où un nom a été donné)
			$nom_bungalow=$answer['nom'];
			$query=$bdd->prepare('UPDATE '.$bung_table.' SET nb_nainsa=:r_nbnainsa, nainsa'.$new_nbnainsa.'=:r_naina WHERE id=:r_id;');
			if($answer=$query->execute(array(':r_nbnainsa'=>$new_nbnainsa,':r_naina'=>$id, ':r_id'=>$bungalow))){$flag=1;}else{$flag=0;};
		}
		if($flag)
		{
			$clef = sha1(microtime(NULL)*100000);
			$query=$bdd->prepare('UPDATE '.$nainsa_table.' SET clef=:r_clef, reservationbungalow=:r_reservationbungalow WHERE id=:r_id;');
			if($answer=$query->execute(array('r_clef'=>$clef,'r_reservationbungalow'=>1,'r_id'=>$id)))
			{
								// Préparation du mail contenant le lien d'activation
				$destinataire = $email;
				$sujet = "[WEI 2011 by Hypnoz] Confirme la réservation de ton bungalow!" ;



				$headers = 'From: Staff WEI Hypnoz <contact@hypnoz2011.com>'."\r\n";



				// Le lien d'activation est composé du login(log) et de la clé(cle)
				$message= "<img src='' width='700' height='183' /><br></br><br></br><br></br>


				Bonjour ".$prenom." ".$nom.",<br></b><br></br>

				Tu viens de réservé le bungalow du doux nom de ".$nom_bungalow.", dans l'équipe ".str_replace('_',' ',$couleur)."<br/><br/>";
				$liste="";
				$query=$bdd->prepare('SELECT * FROM '.$bung_table.' WHERE id=:r_id;');
				$answer=$query->execute(array('r_id'=>$id));
				for($i=1;$i<$new_nbnainsa;$i++)
				{
					$query=$bdd->prepare('SELECT nom,prenom,email FROM '.$nainsa_table.' WHERE id=:r_id;');
					$answer=$query->execute(array('r_id'=>$answer['naina'.$i]));
					$answer=$query->fetch();
					$liste.="<li>".$answer['prenom']." ".$answer['nom']."</li>";
					$sujetbis = "[WEI 2011 by Hypnoz]".$prenom." ".$nom." s'est inscrit dans le bungalow ".$nom_bungalow."!" ;
					$messagebis="<img src='' width='700' height='183' /><br></br><br></br><br></br>


				Bonjour ".$answer['prenom']." ".$answer['nom'].",<br></br>

				Le Staff Hypnoz t'informes que ".$prenom." ".$nom." vient de s'inscrire dans ton bungalow, baptisé ".$nom_bungalow." et appartenant à l'équipe ".str_replace('_',' ',$couleur)."<br><br/>
				<br><br/><br><br/>Bisous tout partout,<br><br/><br><br/>Le Staff Hypnoz";
				mail_utf8($answer['email'], $sujetbis, $messagebis, $headers);
					
					
				}
				if(!empty($liste)){$liste="<ul>".$liste."</ul><br></br><br></br>";$message.=$liste;}
				$message.="Pour valider la réservation de ton bungalow, clique sur le lien suivant:<br></br><br></br>

				<a href=http://www.hypnoz2011.com/bungalows/confirmation.php?l=".urlencode($id)."&c=".urlencode($clef).">http://www.hypnoz2011.com/bungalows/confirmation.php?l=".urlencode($id)."&c=".urlencode($clef)." </a><br></br><br></br>

				Attention, si tu ne valides pas ton inscription dans les 24h, elle sera effacée.<br></br>


				<br></br>---------------<br></br>
				Ceci est un mail automatique, Merci de ne pas y répondre.<br></br>
				En cas de problème, contacter <a href='mailto:wed@hypnoz2011.com'>wed@hypnoz2011.com</a>";


				mail_utf8($email, $sujet, $message, $headers) ; // Envoi du mail
				echo "Ta réservation a bien été enregistrée. Un mail à été envoyé à l'adresse ".$email.". Tu y trouveras un lien de confirmation de ta réservation.";
				$query->closeCursor();
			}
			else
			{
				echo "Une erreur à eu lieu lors de la mise à jour de votre profil. Veuillez réessayer ou contacter <a href='mailto:pierre-edouard@hypnoz2011.com'> l'administrateur du site</a>";
			}
				
		}
		else
		{
			echo "Enregistrement des données impossible, veuillez réessayer ultérieurement s'il-vous-plait.";
		}
		
	}
	else
	{
	echo "Erreur2! Veuillez ressoumettre votre choix ou bien contacter <a href='mailto:pierre-edouard@hypnoz2011.com'> l'administrateur du site</a>";
	
	}
}
else
{
echo "Erreur1! Veuillez ressoumettre votre choix ou bien contacter <a href='mailto:pierre-edouard@hypnoz2011.com'> l'administrateur du site</a>";
	
}