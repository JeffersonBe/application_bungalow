<?php
	//Inclusion de la fonction d'authentification
	include('assets/connect/auth.php');
	//On récupère le résultat
	$level=hothentic();
	//On trie les utilisateurs selon leurs droits d'accès
	if ($level) {
		include('assets/connect/connect_settings.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include('assets/includes/head.php') ?>
		<title>Appli web de la rentrée - Hypnoz - Informations concernant <?php echo $infos['prenom']." ".$infos['nom']; ?></title>
	</head>
	<body>
			<?php include('assets/includes/menu.php') ?>
	        	<div id="fiche">
					<div id='activite_recente'>
					<h1> Listes de cotisants 2011:</div>
					<?php
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
						$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' ORDER BY nom ASC;');
						$query->execute()
					?>
						<table  class="liste_inscrit">
							<?php
								while($answer=$query->fetch()) {
									?>
										<tr class="inscrit">
											<td class="element_inscrit">
												<?php echo $answer['prenom'].' '.$answer['nom'];?>
											</td>
											<td class="element_inscrit">
												<form method="post" action="fiche.php">
													<input type="hidden" name="id" <?php echo 'value="'.$answer['id'].'"'; ?>"/>
													<input type="submit" class="submit" value="Consulter" />
												</form>
											</td>
											<td class="element_inscrit">
												<form method="post" action="etape2.php">
													<input type="hidden" name="id" <?php echo 'value="'.$answer['id'].'"'; ?>"/>
													<input type="submit" class="submit" value="Modifier" />
												</form>
											</td>
										</tr>
									<?php
								}
							$query->closeCursor();
							?>
						</table>

					</div><!-- fin de activité récente -->
			</div><!-- fin de fiche -->
		<?php } else {
		?>
			<?php include('assets/includes/login.php') ?>
		<?php
	}
	?>
	</body>
</html>