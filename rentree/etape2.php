<?php include('assets/connect/auth.php');
	$level=hothentic();
	if($level) {
		include('assets/connect/connect_settings.php');
		if(isset($_POST['id'])) {
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
				$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE id = :r_id;');
					$query->execute(array('r_id' => addslashes($_POST['id'])));
						$infos=$query->fetch();

			if(!empty($infos['numcompte'])){
				$infos['clef_b']=substr($infos['numcompte'],0,5);
					$infos['clef_g']=substr($infos['numcompte'],5,5);
						$infos['clef_c']=substr($infos['numcompte'],10,11);
							$infos['clef_r']=substr($infos['numcompte'],21,2);
			} else {
				$infos['clef_b']='';
					$infos['clef_c']='';
						$infos['clef_g']='';
							$infos['clef_r']='';
			}
		} elseif (isset($_POST['ldap'])) {
			$infos['ldap']=addslashes($_POST['ldap']);
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
				$query=$bdd->prepare('SELECT * FROM '.$ldap_table.' WHERE id = :r_id;');
					$query->execute(array('r_id' => addslashes($_POST['ldap'])));
						$answer=$query->fetch();
			
			list($infos['prenom'], $infos['nom'])= explode(" ", $answer['cn']);
				if(preg_match('/EM/',$answer['title'])) {
					$infos['ecole']='tem';
				} else {
					$infos['ecole'] = 'tsp';
				} if(preg_match('/3/',$answer['title'])) {
					$infos['promo']='2009';
				} elseif(preg_match('/2/',$answer['title'])) {
					$infos['promo']='2010';
				} else {
					$infos['promo']='2011';
				}
		} else {
			if(empty($_POST['nom'])) {
				header('Refresh: 0; url=etape1.php');}else{$infos['nom']=$_POST['nom'];
			} if(empty($_POST['prenom'])) {
				header('Refresh: 0; url=etape1.php');}else{$infos['prenom']=$_POST['prenom'];
			} if(empty($_POST['ecole'])) {
				header('Refresh: 0; url=etape1.php');}else{$infos['ecole']=$_POST['ecole'];
			}
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include('assets/includes/head.php') ?>
	<title>Appli web de la rentrée - Showtime2012 - <?php if(empty($infos['id'])){ echo "Inscription d'un nainA";}else {echo "Modification de la fiche de ".$infos['prenom']." ".$infos['nom'];}?></title>
</head>
	<body onload="javascript:chemin(1);afficheprixbde();afficheprixwei();calcul_bbq();">
	<div id="Full">
			<?php include 'assets/includes/menu.php' ?>
		<div id="Contenu">
			<table id='track' >
				<tr>
					<th scope="col" id='sl1' class='sli' onClick='chemin(1)'>Général</th>
					<th scope="col" id='sl2' class='sli' onClick='chemin(2)'>Rentrée</th>
					<th scope="col"id='sl3' class='sli' onClick='chemin(3)'>Cotiz</th>
					<th scope="col" id='sl4' class='sli' onClick='chemin(4)'>SWEI</th>
					<th scope="col" id='sl5' class='sli' onClick='chemin(5)'>Fin</th>
				</tr>
			</table>
		<div id="container">
		<div id="mygallery" class="stepcarousel">
		<div class="belt">

		<form method="post" action="register.php" id="formulaire">
		<div class="panel">
		<a  class="suivant" OnClick= "go1()">Suivant</a>
		<h1>Informations générales</h1>
		<p>
		<span class='obligatoire'>*: Réponse obligatoire</span><br/><br/>
		<?php if(!empty($infos['id'])){?><input type="hidden" name="id" <?php echo 'value="'.$infos['id'].'"'; ?>/><?php }?>
		<input type="radio" class="radio" name="ecole" id="tsp" value="tsp"
		<?php
		if($infos['ecole'] == 'tsp'){
				echo 'checked="checked"';
			}
		?>
		/>

		<label class="radio" for="tsp">TSP <span class='obligatoire'>*</span></label>
		<input type="radio" class="radio" name="ecole" id="tem" value="tem"
		<?php
		if($infos['ecole'] == 'tem'){
				echo 'checked="checked"';
		}
		?>/><label class="radio" for="tem">TEM<span class='obligatoire'>*</span></label>
		<br/><br/>

				<input type="radio" class="radio" name="sexe" id="m" value="m"
			<?php
			if(!empty($infos['id'])) {
				if($infos['sexe'] == 'm') {
						echo 'checked="checked"';
				}
			}
		?>
		/>

		<label class="radio" for="m">Homme<span class='obligatoire'>*</span></label>
		<input type="radio" class="radio" name="sexe" id="f" value="f"
		<?php
		if(!empty($infos['id'])) {
			if($infos['sexe'] == 'f') {
				echo 'checked="checked"';
			}
		}

		?>/><label class="radio" for="f">Femme<span class='obligatoire'>*</span></label>
		<br/><br/>

		<input type="radio" class="radio" name="promo" id="1annee" value="2011"
		<?php
		if(!empty($infos['id'])){ //cas du mode édition
			if($infos['promo'] == '2011'){
				echo 'checked="checked"';
			}
		}
		elseif(!empty($infos['ldap'])){ //mode ldap
			if($infos['promo'] == '2011'){
				echo 'checked="checked"';
			}
		}
		?>/>
		<label class="radio" for="1annee">1ère année<span class='obligatoire'>*</span></label>


		<input type="radio" class="radio" name="promo" id="2annee" value="2010"
		<?php
		if(!empty($infos['id'])){ //cas du mode édition
			if($infos['promo'] == '2010'){
				echo 'checked="checked"';
			}
		}
		elseif(!empty($infos['ldap'])){
			if($infos['promo'] == '2010'){
				echo 'checked="checked"';
			}
		}
		?>/>
		<label class="radio" for="2annee">2ème année<span class='obligatoire'>*</span></label>

		<input type="radio" class="radio" name="promo" id="master" value="2009"
		<?php
		if(!empty($infos['id'])){ //cas du mode édition
			if($infos['promo'] == '2009'){
				echo 'checked="checked"';
			}
		}
		elseif(!empty($infos['ldap'])){
			if($infos['promo'] == '2009'){
				echo 'checked="checked"';
			}
		}
		?>/>
		<label class="radio" for="master">Master<span class='obligatoire'>*</span></label>
		<label for="nom">Nom<span class='obligatoire'>*</span> : </label>
			<input type="text" name="nom" id="nom" <?php echo 'value="'.$infos['nom'].'"';?> autocomplete="off"/><br/>
		<label for="prenom">Prénom<span class='obligatoire'>*</span> : </label>
			<input type="text" name="prenom" id="prenom" <?php echo 'value="'.$infos['prenom'].'"';?> autocomplete="off"/><br/>
		<label for="portable">Portable<span class='obligatoire'>* (au choix)</span> : </label>
			<input type="text" name="portable" id="portable" <?php if(!empty($infos['id'])){echo 'value="'.$infos['portable'].'"';}?> autocomplete="off"/><br/>
		<label for="adresse">Adresse : </label>
			<input type="text" name="adresse" id="adresse" <?php if(!empty($infos['id'])){echo 'value="'.$infos['adresse'].'"';} ?> autocomplete="off"/><br/>
		<label for="s2ia">Login s2ia : </label>
			<input type="text" name="s2ia" id="s2ia" <?php if(!empty($infos['id'])){echo 'value="'.$infos['s2ia'].'"';}elseif(!empty($infos['ldap'])){$part=explode(",", $answer['DN']); $uid=substr($part[0],4); echo 'value="'.$uid.'"';}?> autocomplete="off"/><br/>
		<label for="email">Adresse Email<span class='obligatoire'>*</span> : </label>
			<input type="text" name="email" id="email" size='50' autocomplete="off" <?php if(!empty($infos['id'])){echo 'value="'.$infos['email'].'"';}?>/><br/>
		</p>

		</div>
		<div class="panel">
			<a class="precedent" OnClick= "chemin(1)">Précédent</a>
			<a class="suivant" OnClick= "chemin(3)">Suivant</a>
		<h1>Formulaire de rentrée</h1>
		<p>
				<input type="hidden" name="ficherentree" id="ficherentree" <?php if(!empty($infos['id'])){if($infos['ficherentree']=='oui'){echo 'checked="checked"';}} ?> />
			<br/>
			<input type="checkbox" name="interetsg" id="interetsg" <?php if(!empty($infos['id'])){if($infos['interetsg']=='oui'){echo 'checked="checked"';}} ?> /><label for="interetsg">Interessé par l'ouverture d'un compte SoGé </label><br/><br/>
			<input type="checkbox" name="interetwei" id="interetwei" <?php if(!empty($infos['id'])){if($infos['interetwei']=='oui'){echo 'checked="checked"';}} ?> /><label for="interetwei">Interessé par le WEI </label><br/>
			<br/>
			<input type="checkbox" name="bbqsam" id="bbqsam" onClick="calcul_bbq();" <?php if(!empty($infos['id'])){if($infos['bbqsam']=='oui'){echo 'checked="checked"';}} ?>/><label for="bbqsam">Barbecue du Samedi 3</label><br/>
			<input type="checkbox" name="bbqdim" id="bbqdim" onClick="calcul_bbq();" <?php if(!empty($infos['id'])){if($infos['bbqdim']=='oui'){echo 'checked="checked"';}} ?>/><label for="bbqdim">Barbecue du Dimanche 4</label><br/>
			<input type="checkbox" name="bbqmar" id="bbqmar" onClick="calcul_bbq();" <?php if(!empty($infos['id'])){if($infos['bbqmar']=='oui'){echo 'checked="checked"';}} ?>/><label for="bbqmar">Barbecue du Mardi 6</label><br/>
			<input type="checkbox" name="bbqmer" id="bbqmer" onClick="calcul_bbq();" <?php if(!empty($infos['id'])){if($infos['bbqmer']=='oui'){echo 'checked="checked"';}} ?>/><label for="bbqmer">Barbecue du Mercredi 7</label><br/>
			<input type="checkbox" name="bbqjeu" id="bbqjeu" onClick="calcul_bbq();" <?php if(!empty($infos['id'])){if($infos['bbqjeu']=='oui'){echo 'checked="checked"';}} ?>/><label for="bbqjeu">Barbecue du Jeudi 8</label><br/>
			<input type="checkbox" name="bbqven" id="bbqven" onClick="calcul_bbq();" <?php if(!empty($infos['id'])){if($infos['bbqven']=='oui'){echo 'checked="checked"';}} ?>/><label for="bbqven">Brunch du Vendredi 9</label><br/>
			<input type="checkbox" name="bbqpaye" id="bbqpaye" onClick="calcul_bbq();" <?php if(!empty($infos['id'])){if($infos['bbqpaye']=='oui'){echo 'checked="checked"';}} ?>/><label for="bbqpaye">Barbecues/Brunch payés</label><br/><div id="prixbbq" ></div></p>
			</p>
		</div>
		<div class="panel">
			<a class="precedent" OnClick= "chemin(2)">Précédent</a>
			<a class="suivant" OnClick= "go2()">Suivant</a>
		<h1>Démarches administratives</h1>
		<p>
		<input type="checkbox" name="cotisantbde" id="cotisantbde" onClick="enable('cotisantbde','tarif_bde')" onChange="afficheprixbde()" <?php if(!empty($infos['id'])){if($infos['cotisantbde']=='oui'){echo 'checked="checked"';}} ?> /><label for="cotisantbde">Cotisant BDE </label> ==> <span id='afficheprixbde'>150€</span><br/>
		<fieldset id="tarif_bde"
		<?php if(!empty($infos['id']))
			{
				if($infos['cotisantbde']=='non')
				{
					echo ' disabled="disabled"';
				}
			}
else
{
echo ' disabled="disabled"';
}			?>>
		<legend>Si cotisant</legend>
		<label for="tarifbde">Tarif appliqué:</label>
		<input type="radio" class="radio" name="tarifbde" id="bde_1a" value="1a" onChange="afficheprixbde()" <?php if(!empty($infos['id'])){if($infos['tarifbde']=='1a'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> />
		<label class="radio"  for="bde_1a">1A</label>

		<input type="radio"  class="radio" name="tarifbde" id="bde_erasmus6" value="erasmus6" onChange="afficheprixbde()" <?php if(!empty($infos['id'])){if($infos['tarifbde']=='erasmus6'){echo 'checked="checked"';}} ?> />
		<label class="radio" for="bde_erasmus6">Erasmus 6 mois</label>

		<input type="radio"  class="radio" name="tarifbde" id="bde_erasmus12" value="erasmus12" onChange="afficheprixbde()" <?php if(!empty($infos['id'])){if($infos['tarifbde']=='erasmus12'){echo 'checked="checked"';}} ?> />
		<label class="radio" for="bde_erasmus12">Erasmus 1 an</label>

		<input type="radio"  class="radio" name="tarifbde" id="bde_perso" value="perso" onChange="afficheprixbde()" <?php if(!empty($infos['id'])){if($infos['tarifbde']==-1){echo 'checked="checked"';}} ?> />
		<label class="radio" for="perso">Tarif spécial:<input type="text" name="prixbde" id="prixbde" size="3" maxlength="3" onKeyUp="afficheprixbde()" autocomplete="off" <?php if(!empty($infos['id'])){if($infos['tarifbde']=='perso'){echo 'value="'.$infos['prixbde'].'"';}} ?> /></label>
		<br/><br/>

		Paiement :
		<input type="radio" class="radio" name="typepaiementcotiz" id="prelevementCotiz" value="prelevement"
		<?php
		if(!empty($infos['id'])){
			if($infos['cotisantbde'] == 'oui'){
				if($infos['typepaiementcotiz'] == 'prelevement'){
					echo 'checked=true';
				}
			}
		}
		?>/>
		<label class="radio" for="prelevementcotiz">Prélèvement</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" class="radio" name="typepaiementcotiz" id="chequeCotiz" value="cheque"
		<?php
		if(!empty($infos['id'])){
			if($infos['cotisantbde'] == 'oui'){
				if($infos['typepaiementcotiz'] == 'cheque'){
					echo 'checked=true';
				}
			}
		}
		?>
		/>
		<label class="radio"  for="chequeCotiz">Chèque</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio"  class="radio" name="typepaiementcotiz" id="liquideCotiz" value="liquide"
		<?php
		if(!empty($infos['id'])){
			if($infos['cotisantbde'] == 'oui'){
				if($infos['typepaiementcotiz'] == 'liquide'){
					echo 'checked=true';
				}
			}
		}
		?>
		/>
		<label class="radio" for="liquideCotiz">Liquide</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio"  class="radio" name="typepaiementcotiz" id="nonpayeCotiz" value="nonpaye"
		<?php
		if(!empty($infos['id'])){
			if($infos['cotisantbde'] == 'oui'){
				if($infos['typepaiementcotiz'] == 'nonpaye'){
					echo 'checked=true';
				}
			}
		}
		else
		{
			echo 'checked=true';
			}
		?>
		/>
		<label class="radio" for="nonpayeCotiz"><b>Non Payé</b></label>
		</fieldset>
		<br/><br/>

		<input type="checkbox" name="comptesg" id="comptesg" onChange="afficheprixbde();afficheprixwei();" onClick="enable('comptesg','clef_b');enable('comptesg','clef_g');enable('comptesg','clef_c');enable('comptesg','clef_r');" <?php if(!empty($infos['id'])){if($infos['comptesg']=='oui'){echo 'checked="checked"';}} ?>/><label for="comptesg">A crée un compte Société Générale </label><br/>
		<label for="rib">Si oui, RIB: </label><input type="text" name="clef_b" id="clef_b" size="5" maxlength="5" onKeyup="clef_rib();" <?php if(!empty($infos['id'])){echo 'value="'.$infos['clef_b'].'"';}else{echo 'value="30003"';echo ' disabled="true"';}?> /> <input type="text" name="clef_g" size="5" maxlength="5" id="clef_g" onKeyup="clef_rib()" <?php if(!empty($infos['id'])){echo 'value="'.$infos['clef_g'].'"';echo ' disabled="true"';}?> /> <input type="text" name="clef_c" id="clef_c" size="12" maxlength="11" onKeyup="clef_rib();" <?php if(!empty($infos['id'])){echo 'value="'.$infos['clef_c'].'"';echo ' disabled="true"';}?> autocomplete="off"/> <input type="text" name="clef_r" id="clef_r" size="2" maxlength="2" onKeyup="clef_rib();" <?php if(!empty($infos['id'])){echo 'value="'.$infos['clef_r'].'"';echo ' disabled="true"';}?> autocomplete="off"/> <div id="verif_rib_incomplet">Rib incomplet</div><div id="verif_rib_vrai">Rib correct</div><div id="verif_rib_faux">Rib erroné</div><br/>
		<input type="checkbox" name="prelevement" id="prelevement" <?php if(!empty($infos['id'])){if($infos['prelevement']=='oui'){echo 'checked="checked"';}} ?> /><label for="prelevement">Autorisation de prélèvement remplie </label><br/><br/>
		<input type="checkbox" name="boursier" id="boursier" onChange="afficheprixbde();afficheprixwei();" onClick="enable('boursier','pallier')" <?php if(!empty($infos['id'])){if($infos['boursier']=='oui'){echo 'checked="checked"';}} ?> /><label for="boursier">Demande de Bourse</label><br/>
		<label for="pallier">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Si oui, pallier de la bourse</label>
		<select name="pallier" id="pallier" onChange="afficheprixbde();afficheprixwei();" <?php if(!empty($infos['id'])){if($infos['boursier']!='oui'){ echo 'disabled="disabled"';}}else{echo 'disabled="disabled"';} ?> >
			<option value="0" selected="selected"> 0</option>
			<option value="1"> 1</option>
			<option value="2"> 2</option>
			<option value="3"> 3</option>
			<option value="4"> 4</option>
			<option value="5"> 5</option>
			<option value="6"> 6</option>
		</select>
<br/><br/>

		</p>
		</fieldset>
		</div>
		<div class="panel">
			<a class="precedent" OnClick= "chemin(3)">Précédent</a>
			<a class="suivant" OnClick= "go3()">Suivant</a>
			<h1>Informations SEI/WEI</h1>
		<p>
		<input type="checkbox" name="wei" id="wei" onChange="afficheprixwei()" onClick="enable('wei','tarif_wei')"
			<?php
				if (!empty($infos['id'])) {
					if($infos['wei']=='oui') {
						echo 'checked="checked"';
					}
				}
			?>
			/>
		<label for="wei">Inscrit au WEI </label> ==> <span id='afficheprixwei'>250€</span><br/>
		<fieldset id="tarif_wei"
		<?php if(!empty($infos['id']))
			{
				if($infos['wei']=='non')
				{
					echo ' disabled="disabled"';
				}
			}
			else
			{
				echo ' disabled="disabled"';
			}

			?>>
		<legend>Si oui</legend>
		<label for="prixWei">Tarif appliqué:</label>
		<input type="radio" class="radio" name="tarifwei" id="wei_1a" value="1a" onChange="afficheprixwei()" <?php if(!empty($infos['id'])){if($infos['tarifwei']=='1a'){echo 'checked="checked"';}}else{ echo 'checked="checked"';} ?> />
		<label class="radio"  for="wei_1a">1A</label>
		<input type="radio"  class="radio" name="tarifwei" id="wei_erasmus6" value="erasmus6" onChange="afficheprixwei()" <?php if(!empty($infos['id'])){if($infos['tarifwei']=='erasmus6'){echo 'checked="checked"';}} ?> />
		<label class="radio" for="wei_erasmus6">Erasmus 6 mois</label>
		<input type="radio"  class="radio" name="tarifwei" id="wei_erasmus12" value="erasmus12" onChange="afficheprixwei()" <?php if(!empty($infos['id'])){if($infos['tarifwei']=='erasmus12'){echo 'checked="checked"';}} ?> />
		<label class="radio" for="wei_erasmus12">Erasmus 1 an</label>

		<input type="radio"  class="radio" name="tarifwei" id="wei_perso" value="perso" onChange="afficheprixwei()" <?php if(!empty($infos['id'])){if($infos['tarifwei']=='perso'){echo 'checked="checked"';}} ?> />
		<label class="radio" for="prixwei">Tarif spécial:<input type="text" name="prixwei" id="prixwei" onKeyUp="afficheprixwei()" size="3" maxlength="3" autocomplete="off" <?php if(!empty($infos['id'])){if($infos['tarifwei']=='perso'){echo 'value="'.$infos['prixwei'].'"';}} ?> /></label>
		<br/><br/>

		Paiement :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" class="radio" name="typepaiementwei" id="prelevementwei" value="prelevement" <?php if(!empty($infos['id'])){if($infos['wei']=='oui'){if($infos['typepaiementwei'] == 'prelevement'){echo 'checked="checked"';}} else{ echo 'disabled="disabled"';}} ?>  />
		<label class="radio" for="prelevementWei">Prélèvement</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" class="radio" name="typepaiementwei" id="chequewei" value="cheque" <?php if(!empty($infos['id'])){if($infos['wei']=='oui'){if($infos['typepaiementwei'] == 'cheque'){echo 'checked="checked"';}}} ?> />
		<label class="radio"  for="chequeWei">Chèque</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio"  class="radio" name="typepaiementwei" id="liquidewei" value="liquide" <?php if(!empty($infos['id'])){if($infos['wei']=='oui'){if($infos['typepaiementwei'] == 'liquide'){echo 'checked="checked"';}}} ?> />
		<label class="radio" for="liquideWei">Liquide</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio"  class="radio" name="typepaiementwei" id="nonpayewei" value="nonpaye" <?php if(!empty($infos['id'])){if($infos['wei']=='oui'){if($infos['typepaiementwei'] == 'nonpaye'){echo 'checked="checked"';}}}else{echo 'checked="checked"';} ?> />
		<label class="radio" for="nonPayeWei"><b>Non payé</b></label>
		<br/><br/>

		<input type="checkbox" name="caution" id="caution" <?php if(!empty($infos['id'])){if($infos['caution']=='oui'){echo 'checked="checked"';}} ?>/><label for="caution">Chèque de caution </label><br/>
		<br/><br/>

		Régime alimentaire: <br/>
		<input type="radio" class="radio" name="regime" id="cachere" value="cachere" <?php if(!empty($infos['id'])){ if($infos['regime'] == 'cachere'){echo 'checked="checked"';}} ?> />
		<label class="radio" for="cachere">Cachère</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" class="radio" name="regime" id="hallal" value="hallal" <?php if(!empty($infos['id'])){ if($infos['regime'] == 'hallal'){echo 'checked="checked"';}} ?>/>
		<label class="radio"  for="hallal">Hallal</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" class="radio" name="regime" id="vegetarien" value="vegetarien" <?php if(!empty($infos['id'])){ if($infos['regime'] == 'vegetarien'){echo 'checked="checked"';}} ?>/>
		<label class="radio"  for="vegetarien">Végétarien</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio"  class="radio" name="regime" id="nothingSpecial" value="nothingSpecial" <?php if(!empty($infos['id'])){ if($infos['regime'] == 'nothingSpecial'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> />
		<label class="radio" for="nothingSpecial">Rien de tout ça !</label>
		</fieldset>
		</p>
			</div>
			<div class="panel">
				<a class="precedent" OnClick= "chemin(4)">Précédent</a>
				<h1>Renseignements supplémentaires</h1>
					<p>
						<input type="checkbox" name="technoparade" id="technoparade" <?php if(!empty($infos['id'])){if($infos['technoparade']=='oui'){echo 'checked="checked"';}} ?>/><label for="technoparade">Viendra à la Technoparade </label><br/>
						<input type="checkbox" name="teeshirttechnoparade" id="teeshirttechnoparade" <?php if(!empty($infos['id'])){if($infos['teeshirttechnoparade']=='oui'){echo 'checked="checked"';}} ?> /><label for="teeshirttechnoparade">Achètera le Tshirt de la Technoparade </label><br/>
						<br/>Prix Cotisation BDE: <span id="afficheprixbde2"></span>
						<br/>Prix Wei: <span id="afficheprixwei2"></span>
						<br/> Prix Total Barbeucs: <span id="afficheprixbbq"></span>
						<p>
						<input type="button" id="submit_crea" onClick='go()' value="<?php if(!empty($infos['id'])){ echo'Mettre &agrave; jour la fiche du nainA';} else{echo 'Ajouter le NainA &agrave; la base de donn&eacute;es';} ?>" />
					</p>
			</div>
		</form>
		</div>
		</div>
			<script type="text/javascript" src="assets/js/jquery.js"></script>
			<script type="text/javascript" src="assets/js/rib.js" charset="iso-8859-1"> </script>
			<script type="text/javascript" src="assets/js/functions.js" charset="iso-8859-1"> </script>
			<script type="text/javascript" src="assets/js/stepcarousel.js"></script>
		<?php
	} else {
		?>
			<?php include('assets/includes/login.php') ?>
		<?php
	}
?>
</body>
</html>