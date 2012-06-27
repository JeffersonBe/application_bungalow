<?php

//Nombre de colonnes pour l'affichages du contenun des Bungalows
	$nb_colonnes=4;

//Traitement des noms et prénoms
	$nom_raw = addslashes($_POST['nom']);

//Parsing du nom
	$find = array('à','â','ä','é','è','ê','ë','î','ï','ç','ù','ü','ô','ö');
	$replace = array('a','a','a','e','e','e','e','i','i','c','u','u','o','o');
	$nom = strtoupper(str_replace($find,$replace,strtolower($nom_raw)));
	$prenom_raw = addslashes($_POST['prenom']);

//parsing du prenom
	$prenom = strtolower(str_replace($find,$replace,$prenom_raw));

//Informations de connexion
include('connect_settings.php');
include('bungalows.php');

$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);

//Vérification que l'utilisateur est bien inscrit au WEI
$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE nom=:r_nom AND prenom=:r_prenom;');
if($answer=$query->execute(array('r_nom'=>$nom,'r_prenom'=>$prenom)))
{
	if($answer=$query->fetch())
	{
		//Si Oui
		if($answer['reservationbungalow']!=2)
		{
		$msg=0;
		?>
		Bonjour <?php echo $prenom.' '.$nom;?>, Tu peux désormais choisir ton Bungalow. Si tu choisis un Bungalow vide, n'hésite pas à lui donner un nom!
		<form method="post" action="assets/includes/register.php" id="bungalows_form">
			<input type="hidden" name="id_eleve" id="id_eleve" value="<?php echo $answer['id'];?>"/>
			<input type="hidden" name="nom" id="nom2" value="<?php echo $nom;?>"/>
			<input type="hidden" name="prenom" id="prenom2" value="<?php echo $prenom;?>"/>
			<input type="hidden" name="bungalow" id="bungalow" value=""/>
		<div id="wrapper_bungalow">
		<table id='bugalows_table'>
			<?php
			$query=$bdd->prepare('SELECT * FROM '.$bung_table.';');
			if($answer=$query->execute())
			{
				$i=0;
				?>
				<tr width='100'>
				<?php
				while($answer=$query->fetch())
				{
					$i=$i+1;
					if($i%$nb_colonnes==1)
					{
						echo '<tr>';
					}
					?>

					<?php
					if($answer['nb_nainsa']<$answer['contenance'])
					{
						?>
						<td class='cell_libre' id='cell_<?php echo $answer['id'];?>'>
						<?php
					}
					else
					{
						?>
						<td class='cell_utilisee' id='cell_<?php echo $answer['id'];?>'>
						<?php
					}
					$titre="";
					for($j=1;$j<=$answer['nb_nainsa'];$j++)
					{
						$query2=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE id=:r_id;');
						$answer2=$query2->execute(array('r_id'=>$answer['nainsa'.$j]));
						$answer2=$query2->fetch();
						$titre=$titre."<li>".$answer2['prenom']." ".$answer2['nom']."</li>";
					}
					if(empty($titre)){$titre="vide";}else{$titre="<ul class='liste_bung'>".$titre."</ul>";}
					?>
					<a href="#" title="<?php echo $titre;?>" onClick=<?php echo 'choose('.$answer['id'].')';?>>
					<div class='nb_nainsa'><?php echo $answer['nb_nainsa'];?></div>
					<div class='contenance'><?php echo $answer['contenance'];?></div>
					<img class='img_bung' src='assets/img/bungalow_<?php echo $equipe_officiel[$answer['equipe']]['couleur'];?>.png'/></a><br/>

					<?php if($answer['nom']=='')
						{
							?>
							<input type='text' class='nom_bungalow' size='10' name='<?php echo $answer['id'];?>' id='<?php echo $answer['id'];?>' value=''/>
							<?php
						}
						else
						{
							?>
							<h3 class='nom_bungalow' id='<?php echo $answer['id'];?>'><?php if(strlen($answer['nom'])<=10){ echo $answer['nom'];}else{echo "<a href='#' title='".$answer['nom']."'>".substr($answer['nom'], 0, 10)."...</a>";}?></h3>
							<?php
						}
					?>
					</a>
					</td>

					<?php
					if($i%$nb_colonnes==0)
					{
						echo '</tr>';
					}
				}
				if($i%$nb_colonnes!=0)
				{
					for($j=1+($i%$nb_colonnes);$j<=$nb_colonnes;$j++)
					{
						echo '<td></td>';
					}
					echo '</tr>';
				}
			?>
		</table>
		</div>
			<input type="button" class="submit" id="submit2" value="Enregistrer" />
		</form>
		<?php
	}
	}
	else
	{
	?>
		<p>Tu as déjà réservéet confirmé ton bungalow.<br/>
			En cas de problème ou d'urgence contacte nous <a href="mailto:contact@showtime2012.fr">par email</a> ou bien passe nous voir au local BDE situé au Foyer.
		</p>
	<?php
	}
	}
	else
	{
		//Il n'est pas inscrit
		?>
			<p>
				Tu n'es pas inscrit(e) au WEI 2011 by Showtime2012.<br/>
				Pour t'inscrire, Contacte un membre du bde <a href="mailto:contact@showtime2012.fr">par email</a> ou bien rendez-vous au local BDE situé au Foyer.
			</p>
		<?php
	}
}
else
{
	//Impossible de se connecter à la base de donnée
	echo 'Impossible de se connecter à la base de donnée';
}

?>