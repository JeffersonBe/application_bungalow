<?php

include('../rentree/connect/connect_settings.php');

function mail_utf8($to, $subject, $message, $header) 
{
  $header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";
  mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header_ . $header);
}

$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);

//Connexion à la base de donnée pour la scroller
//$query=$bdd->prepare('SELECT * FROM '.$nainsa_table." WHERE prenom='pierre' AND nom='RABAULT';");
$query=$bdd->prepare('SELECT * FROM '.$nainsa_table." WHERE wei='oui' AND prelevement='oui' AND tarifbde='1a' AND boursier='non';");
if($answer=$query->execute())
{
	while ($answer=$query->fetch())
	{
		echo "Envoi à ".$answer['prenom'].' '.$answer['nom']."...";
		// Préparation du mail avec les infos importantes

		$sujet = "[WEI 2012 by Showtime] WEI Prélèvement Partie I !" ;

		//L'expéditeur
		$headers = 'From: Tresorerie Showtime <contact@showtime2012.com>'."\r\n";

		// Le contenu du mail
		$message= "<img src='http://www.hypnoz2011.com/bungalows/img/wei_hypnoz.jpg' width='350' height='364' style='margin-right:auto;margin-left:auto;text-align:center;'/><br></br>


		Bonjour ".$answer['prenom']." ".$answer['nom'].",<br/><br/>

		Nous tenons à t'informer qu'au 30 Septembre tu vas être prélevé de la première partie du payement de ton WEI.<br/>
		Comme précisé lors de ton inscription, elle s'élève à 60 euros.<br/> 
		Nous te demandons de bien veiller à ce que ton compte soit suffisamment approvisionné.<br/>
		Toute facturation liée à un rejet serait alors à ta charge.<br/>

		Pour toute question, n'hésite pas à nous contacter à l'adresse <a href='mailto:contact@hypnoz2011.com'>contact@hypnoz2011.com</a> ou en te rendant au local BDE situé au foyer.<br/>
		Get Hype, Make Noize,<br/><br/>

		Le staff Showtime
		<br/>
		<br/>
		";
		$emailecole=strtolower($answer['prenom']).'.'.strtolower($answer['nom']).'@it-sudparis.eu';	
		if($answer['email']!='contact@showtime2012.com')
		{
			mail_utf8($answer['email'], $sujet, $message, $headers);
			echo "OK perso...";
		}
		mail_utf8($emailecole, $sujet, $message, $headers);
		echo "OK.<br/>";
		
	}
	$query->closeCursor();
	echo "Tout à été envoyé.";
}
else
{
	echo "Erreur de connection à la base de donnée.";
}
?>