<?php
//Inclusion de la fonction d'authentification
include('assets/connect/auth.php');
//On récupère le résultat
$level=hothentic();
//On trie les utilisateurs selon leurs droits d'accès
if ($level)
{
	 if(isset($_POST['id']))
		{
			include('assets/includes/tarifs.php');
			include('assets/connect/connect_settings.php');
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
			$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE id = :r_id;');
			$query->execute(array('r_id' => $_POST['id']));
			$query->execute();
			$infos=$query->fetch();
			?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include('assets/includes/head.php') ?>
<title>Appli web de la rentrée - Hypnoz - Informations concernant <?php echo $infos['prenom']." ".$infos['nom']; ?></title>
</head>
	<body>
			<div id="Full">
			    <?php include 'assets/includes/menu.php' ?>
		        	<div id="fiche">
						<p>
							<img src="<?php echo 'https://trombi.it-sudparis.eu/jpegPhoto.php?dn=uid%3D'.$infos['s2ia'].'%2Cou%3DPeople%2Cdc%3Dint-evry%2Cdc%3Dfr';?>" width='150'/><br/>
								<span class='question'>Nom: </span><span class='reponse'><?php echo $infos['nom'];?></span><br/>
								<span class='question'>Prénom: </span><span class='reponse'><?php echo $infos['prenom'];?></span><br/>
								<span class='question'>Sexe: </span><span class='reponse'><?php echo $infos['sexe'];?></span><br/>
								<span class='question'>Ecole: </span><span class='reponse'><?php echo $infos['ecole'];?></span><br/>
								<span class='question'>Promo: </span><span class='reponse'><?php echo $infos['promo'];?></span><br/>
								<span class='question'>Login s2ia: </span><span class='reponse'><?php echo $infos['s2ia'];?></span><br/>
								<span class='question'>Email: </span><span class='reponse'><?php echo $infos['email'];?></span><br/>
								<span class='question'>Numéro de portable: </span><span class='reponse'><?php echo $infos['portable'];?></span><br/>
								<span class='question'>Adresse: </span><span class='reponse'><?php echo $infos['adresse'];?></span><br/>
						</p>
						<p>
							<span class='question'>A rempli la fiche rentrée: </span><span class='reponse'><?php echo $infos['ficherentree'];?></span><br/>
							<span class='question'>Cotisant BDE: </span><span class='reponse'><?php echo $infos['cotisantbde'];?></span></br>
							<span class='question'>Tarif de la cotisation: </span><span class='reponse'><?php if($infos['tarifbde']=='-1'){echo 'tarif personnalisé à '.$infos['prixbde'].' €';}else{echo $infos['tarifbde'];}?></span><br/>
							<span class='question'>Montant de la cotisation: </span><span class='reponse'><?php if($infos['cotisantbde']=='oui'){echo prixBde($infos['tarifbde'],$infos['pallier'],$infos['comptesg']).' €';}else{echo '0€';}?></span><br/>
							<span class='question'>Moyen de paiement de la cotisation BDE: </span><span class='reponse'><?php echo $infos['typepaiementcotiz'];?></span><br/>
							<span class='question'>Intéressé pour ouvrir un compte à la Sogé: </span><span class='reponse'><?php echo $infos['interetsg'];?></span><br/>
							<span class='question'>RIB: </span><span class='reponse'><?php if($level==2){echo $infos['numcompte'];}else{echo 'vous n\'avez pas le niveau de sécurité requis pour voir le RIB';} // un poil débile je l'avoue puisqu'on peut modifier le rib avec le niveau 1 et donc voir le rib.} ?></span><br/>
							<span class='question'>Autorisation de prélèvement: </span><span class='reponse'><?php echo $infos['prelevement'];?></span><br/>
							<span class='question'>Boursier: </span><span class='reponse'><?php echo $infos['boursier'];?></span><br/>
							<span class='question'>Pallier de Bourse: </span><span class='reponse'><?php echo $infos['pallier'];?></span><br/>
						</p>
						<p>
							<span class='question'>Intéressé par le wei: </span><span class='reponse'><?php echo $infos['interetwei'];?></span><br/>
							<span class='question'>Tarif du Wei: </span><span class='reponse'><?php if($infos['tarifwei']=='-1'){echo 'tarif personnalisé à '.$infos['prixwei'].' €';}else{echo $infos['tarifwei'];}?></span><br/>
							<span class='question'>Montant du Wei: </span><span class='reponse'><?php if($infos['wei']=='oui'){echo prixWei($infos['tarifwei'],$infos['pallier'],$infos['comptesg']).' €';}else{echo '0 €';}?></span><br/>
							<span class='question'>Moyen de paiement du WEI: <span class='reponse'><?php echo $infos['typepaiementwei'];?></span><br/>
							<span class='question'>Caution versée: </span><span class='reponse'><?php echo $infos['caution'];?></span><br/>
							<span class='question'>Régime alimentaire: </span><span class='reponse'><?php if($infos['regime']=='nothingSpecial'){echo 'rien à déclarer';}else{echo $infos['regime'];}?></span><br/>
						</p>
						<p>
							<span class='question'>Présent à la technoparade: </span><span class='reponse'><?php echo $infos['technoparade'];?></span><br/>
							<span class='question'>Tee Shirt de la technoparade: </span><span class='reponse'><?php echo $infos['teeshirttechnoparade'];?></span><br/><br>
						</p>
						<form method="post" action="etape2.php">
							<input type="hidden" name="id" <?php echo 'value="'.$infos ['id'].'"'; ?>/></input>
							<input type="submit" class="submit" value="Modifier" /></input>
						</form>
						<?php }
						else { header('Refresh: 10; url=index.php'); }
						?>
				</div>
	</div>

		<?php }
			else {
		?>
			<?php include('assets/includes/login.php') ?>
		<?php
	}
	?>
	</body>
</html>