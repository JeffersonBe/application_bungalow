<?php
	//Inclusion de la fonction d'authentification
	session_start();
		include('assets/connect/auth.php');
	//On récupère le résultat
	$level=hothentic();
	//On trie les utilisateurs selon leurs droits d'accès
		if ($level) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include('assets/includes/head.php') ?>
		<title>Appli web de la rentrée - Hypnoz - Accueil</title>
	</head>
	<body>
		<?php include 'assets/includes/menu.php' ?>
			<div id="contenu">
					<div id="Gauche">
						<img src="<?php echo "assets/img/cache/stat_ecole.jpg"."?".filectime("img/cache/stat_ecole.jpg"); ?>" width="400" height="200" alt="Statistiques TEM et TSP" />
						<img src="<?php echo "assets/img/cache/stat_sexe.jpg"."?".filectime("img/cache/stat_sexe.jpg"); ?>" width="400" height="200" alt="Statistiques fille et garçons" />
					</div>

					<div id="Droite">
						<?php if(!empty($_GET['msg'])){if($_GET['msg']=='1'){?>
						<div id="ajout"> La fiche de <?php echo $_GET['cont'];?> a bien été ajoutée.</div>
							<?php }
						if($_GET['msg']=='2'){?>

						<div id="ajout"> La fiche de <?php echo $_GET['cont'];?> a bien été modifiée.</div><?php }}?>

						<div id='formulaire_recherche'>
							<form method="post" action="etape1.php">
								<p>
									<label for="nom">Nom: </label><input type="text" name="nom" autocomplete="off"/>
									<label for="prenom">Prénom : </label><input type="text" name="prenom" autocomplete="off"/><br/>
										<input type="radio" class="radio" name="ecole" id="tsp" value="tsp">
									<label class="radio" for="tsp">TSP</label>
										<input type="radio" class="radio" name="ecole" id="tem" value="tem">
									<label class="radio" for="tem">TEM</label><br/>
										<input type="submit" class="submit" value="Ajouter/modifier la fiche de ce nainA" /><br/>
								</p>
							</form>
						</div>
						<div id='activite_recente'>
							<div id='titre_activite_recente'>Activités récentes:</div>
							<?php
								include('assets/connect/connect_settings.php');
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
								$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' ORDER BY modification DESC LIMIT 10;');
								$query->execute()
							?>
							<table  class="liste_activites">
								<?php
								while($answer=$query->fetch())
								{
								?>
									<tr class="activite">
										<td class="element_activite"><?php echo date("j-m-Y, G:i", strtotime($answer['modification']));?></td>
										<td class="element_activite">
											<?php if($answer['modification']!=$answer['creation']){?>La fiche de <?php echo $answer['prenom'].' '.$answer['nom'].' a été modifiée.'?>
											<?php }else{?>La fiche de <?php echo $answer['prenom'].' '.$answer['nom'];?> a été crée.<?php }?>
										</td>
										<td class="element_activite">
											<form method="post" action="fiche.php">
												<input type="hidden" name="id" <?php echo 'value="'.$answer['id'].'"'; ?>/>
												<input type="submit" class="submit" value="Consulter" />
											</form>
										</td>
										<td class="element_activite">
											<form method="post" action="etape2.php">
												<input type="hidden" name="id" <?php echo 'value="'.$answer['id'].'"'; ?>/>
												<input type="submit" class="submit" value="Modifier" />
											</form>
										</td>
									</tr>
								<?php
								}
								$query->closeCursor();
								?>
							</table>
						</div><!-- fin de div activité récente -->
					</div><!-- fin de div droite -->
		<?php }
			else {
		?>
			<?php include('assets/includes/login.php') ?>
		<?php
			}
		?>
	</body>
</html>