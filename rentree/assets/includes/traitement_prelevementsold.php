<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Identifier-URL" content=""/>
<meta name="language" content="fr"/>
<meta name="location" content="France"/>
<meta name="Author" content="Pierre-Edouard MONTABRUN"/>
<meta name="Description" content="Application rentrée 2011"/>
<meta name="keywords" content="Application rentree 2011 Télécom SudParis Télécom Ecole de Management"/>
<meta name="htdig-keywords" content=""/>
<meta name="subject" content=""/>
<meta name="Date-Creation-yyyymmdd" content="20110720"/>
<meta name="Audience" content="all"/>
<link rel="stylesheet" media="screen" type="text/css" href="assets/css/style.css" />
<title>Appli web de la rentrée - Hypnoz</title>
</head>
<body>
<?php
	include('connect_settings.php');

//**********************************************
// Définition des fonctions d'écriture du fichier
//**********************************************


        function write_line($nom, $prenom,$rib,$montant, $motif,$fp){

                //Création du destinataire
                $destinataire_bordel = $prenom.' '.$nom;
                $nb_caracteres = strlen($destinataire_bordel);
                if($nb_caracteres > 24 ){
                    $destinataire = substr($destinataire_bordel,'0','23');
                }
                else{
                    while($nb_caracteres != 24){
                        $destinataire_bordel .= ' ';
                        $nb_caracteres = strlen($destinataire_bordel);
                    }
                }
                $destinataire = $destinataire_bordel;

                //Formatage du RIB
                $nbchiffre = strlen($rib);
                $rib = substr($rib,'0','11');
				$rib = "3000300683$rib";

                //Formatage du montant
                $nb_caracteres = strlen($montant);
                if($nb_caracteres > 16 ){
                    $montant = substr($montant,'0','15');
                }
                else{
                    while($nb_caracteres != 16){
                        $montant = '0'.$montant;
                        $nb_caracteres = strlen($montant);
                    }
                }
                //Formatage du Motif
                $nb_caracteres = strlen($motif);
                if($nb_caracteres > 31 ){
                    $motif = substr($motif,'0','30');
                }
                else{
                    while($nb_caracteres != 31){
                        $motif .= ' ';
                        $nb_caracteres = strlen($motif);
                    }
                }

                //On écrit la ligne correspondante
                fputs($fp,"0608        544885            ".$destinataire."SOCIETE GENERALE                ".$rib.$montant.$motif."30003      \n");

        }

        function write_infos($post,$get){
		        //connexion MySQL


            $total = 0; // Variable pour la dernière ligne
            $i = 1; //variable de boucle
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
			$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE id = :r_id;');
			$query->execute(array('r_id' => $_POST['id']));
			for($i=1;$i<=$post['nb_ajouts'];$i++)
			{
            if( !empty($post['ajout'.$i]))
			{

				//On récupère les infos liées à l'id

				$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE id = \':r_id\'');
				$query->execute(array('r_id' => $post['ajout'.$i]));

                //On stocke les variables postées
                $montant = $post['montant'];
                $motif = $post['motif'];

                //On appelle la fonction qui interroge la BDD
				if($answer=$query->fetch())
				{
					//Si il y a bien une ligne et une seule de retournée
                    write_line($answer['nom'],$answer['prenom'],$answer['numcompte'], $montant, $motif);
                    //On oublie pas d'ajouter le montant au total
                    $total+=intval($montant);
					$query->closeCursor();
				}
				else
				{
					//Si il y a 0 ou plus d'une entrée correspondant au nom et au prénom
                    echo 'Erreur d\'ecriture avec l\'ID numéro '.$post['ajout['.$i.']']."\n";
				}
            }
			}
            return $total;
        }

        function write_fichier($post,$get){

        //Première ligne du fichier
            $date = date('dm').substr(date('y'),1,2);
            echo "0308        544885       ".$date."BDE IT-SUDPARIS                                   E     0068300037275571                                               30003      \n";

        //On écrit toutes les lignes en récupérant le total
        $total = write_infos($post,$get);

        //On formate le total
        $nb_caracteres = strlen($total);
        if($nb_caracteres > 16 ){
            $total = substr($total,'0','15');
        }
        else{
            while($nb_caracteres != 16){
                $total = '0'.$total;
                $nb_caracteres = strlen($total);
            }
        }

        //Derniere ligne du fichier
            echo "0808        544885                                                                                    ".$total."                                          \n";
            echo "\n";
        }


//**********************************************
// Appel de la fonction d'écriture
//**********************************************
include('auth.php');
//On récupère le résultat
$level=hothentic();
//On trie les utilisateurs selon leurs droits d'accès
if ($level==2)
	{


?>

	<div id="Full">
		<div id="Bandeau">
        	<img src="img_src/logo_hypnoz.png" alt="" id="logo" width="172" height="100" />
<div id="Menu">
	  <ul class="menu">
			<li class="element_menu"><a href='index.php'>Accueil</a></li>
			<?php if($level==2){?><li class="element_menu"><a href='stats.php'>Stats</a></li>
			<li class="element_menu"><a href='compta.php'>Compta</a></li><?php } ?>
			<li class="element_menu"><a href='deco.php'>Se deco</a></li>
			</ul>
			</div>
		</div>
        	<div id="fiche">
<?php


$fp = fopen("soge.txt","w"); // 1.On ouvre le fichier en lecture/écriture



		//Première ligne du fichier
        $date = date('dm').substr(date('y'),1,2);
        fputs($fp, "0308        544885       ".$date."BDE IT-SUDPARIS                                   E     0068300037275571                                               30003      \n");

        //On écrit toutes les lignes en récupérant le total


            $total = 0; // Variable pour la dernière ligne
            $i = 1; //variable de boucle
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
			for($i=1;$i<=$_POST['nb_ajouts'];$i++)
			{
            if( !empty($_POST['ajout'.$i]))
			{

				//On récupère les infos liées à l'id


				$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE id = :r_id;');
				$query->execute(array('r_id' => $_POST['ajout'.$i]));

                //On stocke les variables postées
                $montant = $_POST['montant'];
                $motif = $_POST['motif'];

                //On appelle la fonction qui interroge la BDD
				if($answer=$query->fetch())
				{
					//Si il y a bien une ligne et une seule de retournée
                    write_line($answer['nom'],$answer['prenom'],$answer['numcompte'], $montant, $motif,$fp);
                    //On oublie pas d'ajouter le montant au total
                    $total+=intval($montant);
					$query->closeCursor();
				}
				else
				{
					//Si il y a 0 ou plus d'une entrée correspondant au nom et au prénom
                    fputs($fp, "Erreur d\'ecriture avec l\'ID numéro ".$_POST['ajout'.$i]."\n");
				}
            }
			}

        //On formate le total
        $nb_caracteres = strlen($total);
        if($nb_caracteres > 16 ){
            $total = substr($total,'0','15');
        }
        else{
            while($nb_caracteres != 16){
                $total = '0'.$total;
                $nb_caracteres = strlen($total);
            }
        }

        //Derniere ligne du fichier
            fputs($fp, "0808        544885                                                                                    ".$total.";                                          \n");
            fputs($fp,"\n");
			fclose($fp);                      // 6.On ferme le fichier
			echo "Fichier créé avec succès";
        }

	else
	{
		echo "erreur: vous devez vous connecter en tant que trésorier pour utiliser cette fonction";
	}
?>

		</div>
	</div>
	</body>
</html>