<?php
//Inclusion de la fonction d'authentification
include'assets/connect/auth.php';
//On récupère le résultat
$level=hothentic();
//On trie les utilisateurs selon leurs droits d'accès
if ($level==2)
{
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include('assets/includes/head.php') ?>
	<script type="text/javascript" src="assets/js/trez.js"></script>
	<title>Appli web de la rentrée - Showtime - Formulaire de prélèvement</title>
</head>

<body>
	<?php include 'assets/includes/menu.php' ?>
    	<div id="fiche-compta">
		<form method='post' action="assets/includes/traitement_prelevements.php">
			<label for='search'>Rechercher: </label><input name="search" id="search" type="text" onKeyup="show();" autocomplete="off"/>
				<input type="button" name="select_search" onClick="sel_search();" id="select_search" value="Sélectionner tout" />
			<div id='liste_recherche'>
			<?php
			include('assets/connect/connect_settings.php');

				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
				$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.';');
				$query->execute();

				echo "<table id='table_recherche' width='380'>";
				$i=0;
					while($answer=$query->fetch())
					  {
					  $i=$i+1;
					  echo "<tr class='element_recherche'>";
					  echo "<th scope='col'><input type='checkbox' value='".$answer['id']."' name='recherche[".$i."]' id='recherche[".$i."]'/></th>";
					  echo "<th scope='col'><label ' for='recherche[".$i."]'>".$answer['nom']." ".$answer['prenom']."</label></th>";
					  echo "<input type='hidden' name='nom[".$i."]' id='nom[".$i."]' value='".$answer['nom']."'/>";
					  echo "<input type='hidden' name='prenom[".$i."]' id='prenom[".$i."]' value='".$answer['prenom']."'/>";
					  echo '</tr>';

					  }
				 echo '</table>';
				 echo "<input type='hidden' name='nb_recherches' id='nb_recherches' value='".$i."'/>";

				$query->closeCursor();
			?>

			</div>
				<input type="button" name="select_ajout" onClick="sel_ajout();" id="select_ajout" value="Sélectionner tout" />
			<div id='liste_ajout'>
				<table id='table_ajout' width='400'>
				</table>
			</div>

			<div id='navig'>
				<input type="button" name="ajouter" onClick="aj();" id="ajouter" value=">> ajouter >>" />
				<input type="button" name="retirer" onClick="ret();" id="retirer" value="<< retirer <<" />
			</div>

			<div id='moar'>
				<fieldset id='info_prelevement'><legend> Informations de prélèvement</legend>
					<textarea name='motif' id='motif' value='Entrez ici le motif du prélèvement.' rows="3" cols="40">Entrez ici le motif du prélèvement.</textarea>
					<label for='montant' id='montant_lab'> Montant à prélever:<br/>(en centimes)</label><br/><input type='text' id='montant' name='montant' maxlength='6' size='6'/>
					<input type="submit" class="submit" id="sub" value="Give me my money!" />
				</fieldset>
			</div><!-- fin de moar -->
		</form><!-- fin de form -->
	</div>
</body>
</html>
	<?php
}
else
{

?>
	<?php include('assets/includes/login.php') ?>

<?php
}
?>
</body>
</html>
