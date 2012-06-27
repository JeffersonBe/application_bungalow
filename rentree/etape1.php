<?php
	include('assets/connect/auth.php');
	$level=hothentic();
	if($level)
	{
		?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include('assets/includes/head.php') ?>
	<script type="text/javascript" src="assets/js/etape1.js" charset="iso-8859-1"> </script>
	<title>Appli web de la rentrée - Hypnoz - Modifier, Consulter, Créer une fiche</title>
</head>
<body>
	<?php include 'assets/includes/menu.php' ?>
        	<div id="fiche">
			<?php
				include('assets/connect/connect_settings.php');
				$flag=0;
		                $find = array('à','â','ä','é','è','ê','ë','î','ï','ç','ù','ü','ô','ö');
		                $replace = array('a','a','a','e','e','e','e','i','i','c','u','u','o','o');

				if(!empty($_POST['nom'])) {
					$flag=1;
					$nom_raw = addslashes($_POST['nom']);
		                //Parsing du nom
		                $nom = strtoupper(str_replace($find,$replace,strtolower($nom_raw)));
				} else{
					$nom="";
				}

				if(!empty($_POST['ecole'])) {
					$ecole=$_POST['ecole'];
				} else {
					$ecole="";
				}

				if(!empty($_POST['prenom'])){
					$prenom_raw = addslashes($_POST['prenom']);
						//parsing du prenom
					$prenom = str_replace($find,$replace,$prenom_raw);
					if($flag){
						$flag=3;
					}else {
						$flag=2;
					}
				} else {
					$prenom="";
				}

				if($flag) {
					$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
					$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);

					switch($flag) {
						case 1:
							$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE nom = :r_nom;');
							$query->execute(array('r_nom' => $nom));
							break;
						case 2:
							$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE prenom = :r_prenom;');
							$query->execute(array('r_prenom' => $prenom));
							break;
						case 3:
							$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE nom = :r_nom AND prenom = :r_prenom;');
							$query->execute(array('r_nom' => $nom, 'r_prenom' => $prenom));
							break;
						}

					$query->execute();

					if($answer=$query->fetch()) {
						?>
				Il y a déjà des inscrits avec un nom similaire dans notre base de donnée:<br/>
				<table class='listeprop' width="350">
				<tr>
					<th scope="col">Nom</th>
					<th scope="col">Prénom</th>
					<th scope="col">Ecole</th>
					<th scope="col">    </th>
					<th scope="col">    </th>
				</tr>
				<?php
				do {
					?>
						<tr>
							<td><?php echo $answer['nom']; ?></td>
							<td><?php echo $answer['prenom']; ?></td>
							<td><?php echo $answer['ecole']; ?></td>
							<td>
								<form method="post" action="fiche.php">
									<input type="hidden" name="id" <?php echo 'value="'.$answer['id'].'"'; ?>/>
									<input type="submit" class="submit" value="Consulter" />
								</form>
							</td>
							<td>
								<form method="post" action="etape2.php">
									<input type="hidden" name="id" <?php echo 'value="'.$answer['id'].'"'; ?>/>
									<input type="submit" class="submit" value="Modifier" />
								</form>
							</td>
						</tr>
					<?php
				} while($answer=$query->fetch())
				?>

				</table>
				<br/><br/>Ou bien ...<br/><br/>

			<?php
			}

		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

		switch($flag) {
			case 1:
				$query=$bdd->prepare('SELECT * FROM '.$ldap_table.' WHERE sn LIKE :r_nom;');
				$query->execute(array('r_nom' => $nom.'%'));
				break;
			case 2:
				$query=$bdd->prepare('SELECT * FROM '.$ldap_table.' WHERE cn LIKE :r_prenom;');
				$query->execute(array('r_prenom' => $prenom.'%'));
				break;
			case 3:
				$query=$bdd->prepare('SELECT * FROM '.$ldap_table.' WHERE sn LIKE :r_nom;');
				$query->execute(array('r_nom' => $nom.'%'));
				break;
		}

		if($answer=$query->fetch()) {

			?>
			Sélectionnez un nom dans la base de donnée de l'école:<br/>
			<table class='listeprop' width="350">
				<tr>
					<th scope="col">    </th>
					<th scope="col">Nom</th>
					<th scope="col">Prénom</th>
					<th scope="col">Ecole</th>
				</tr>
			<?php
			$n=0;
			do {
				list($prenombis, $nombis)= explode(" ", $answer['cn']);
				if(preg_match('/EM/',$answer['title'])) {
					$ecolebis='tem';
				}
				elseif(preg_match('/EI/',$answer['title'])) {
					$ecolebis='tsp';
				} else {
					$ecolebis='';
				}
				?>
					<tr class='selectldap' onClick='go(<?php $part=explode(",", $answer['DN']); $uid=substr($part[0],4); echo $n;?>)'>
						<td>
							<img src="<?php echo 'https://trombi.it-sudparis.eu/jpegPhoto.php?dn=uid%3D'.$uid.'%2Cou%3DPeople%2Cdc%3Dint-evry%2Cdc%3Dfr';?>" width='60'/>
								<form method="post" id='form_<?php echo $n;?>' action="etape2.php">
								<input type="hidden" name="ldap" <?php echo 'value="'.$answer['id'].'"'; ?>/>
								</form>
						</td>
						<td><?php echo $nombis; ?></td>
						<td><?php echo $prenombis; ?></td>
						<td><?php echo $ecolebis; ?></td>
					</tr>
				<?php
				$n=$n+1;
			} while($answer=$query->fetch())
			?>
		</table>
		<br/><br/>Ou bien ...<br/><br/>
			<?php }}?>
				<form method="post" action="etape2.php">
					<p>
						<label for="nom">Nom: </label>
							<input type="text" name="nom" value="<?php echo($nom);?>" autocomplete="off"/>
						<label for="prenom">Prénom : </label><input type="text" name="prenom" value="<?php echo($prenom);?>" autocomplete="off"/>
							<input type="radio" class="radio" name="ecole" id="tsp" value="tsp" <?php if($ecole=='tsp'){echo 'checked="checked"';}?>>
						<label class="radio" for="tsp">TSP</label>
							<input type="radio" class="radio" name="ecole" id="tem" value="tem" <?php if($ecole=='tem'){echo 'checked="checked"';}?>>
						<label class="radio" for="tem">TEM</label>
							<input type="submit" class="submit" value="Ajouter la fiche de ce nainA" />
					</p>
				</form>
		</div>
		<?php
	} else{
		?>
			<?php include('includes/login.php') ?>
		<?php
	}
?>
</body>
</html>
