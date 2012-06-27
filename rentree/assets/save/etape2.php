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
<link rel="stylesheet" media="screen" type="text/css" href="style.css" />
<script LANGUAGE="Javascript" SRC="rib.js" charset="iso-8859-1"> </script>
<script LANGUAGE="Javascript" SRC="functions.js" charset="iso-8859-1"> </script>
<title>Appli web de la rentrée - Hypnoz</title>
</head>
<body>
<?php
	include('auth.php');
	include('tarifs.php');
	$level=hothentic();
	if($level)
	{
		if(isset($_POST['id']))
		{
			include('connect_settings.php');
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
			$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE id = :r_id;');
			$query->execute(array('r_id' => $_POST['id']));
			$query->execute();
			$answer=$query->fetch();
			$infos['id']=$answer['id'];
			$infos['nom']=$answer['nom'];
			$infos['prenom']=$answer['prenom'];
			$infos['ecole']=$answer['ecole'];
			$infos['sexe']=$answer['sexe'];
			$infos['promo']=$answer['promo'];
			$infos['s2ia']=$answer['s2ia'];
			$infos['email']=$answer['email'];
			$infos['datenaissance']=$answer['datenaissance'];
			$infos['lieunaissance']=$answer['lieunaissance'];
			$infos['portable']=$answer['portable'];
			$infos['fixe']=$answer['fixe'];
			$infos['adresse']=$answer['adresse'];
			$infos['ficherentree']=$answer['ficherentree'];
			$infos['cotisantbde']=$answer['cotisantbde'];
			$infos['typepaiementcotiz']=$answer['typepaiementcotiz'];
			$infos['interetsg']=$answer['interetsg'];
			$infos['comptesg']=$answer['comptesg'];
			$infos['numcompte']=$answer['numcompte'];
			if(!empty($numcompte)){
			$infos['clef_b']=substr(1,5,$answer['numcompte']);
			$infos['clef_g']=substr(6,10,$answer['numcompte']);
			$infos['clef_c']=substr(11,21,$answer['numcompte']);
			$infos['clef_r']=substr(22,23,$answer['numcompte']);
			}
			else
			{
			$infos['clef_b']='';
			$infos['clef_c']='';
			$infos['clef_g']='';
			$infos['clef_r']='';
			}
			$infos['prelevement']=$answer['prelevement'];
			$infos['boursier']=$answer['boursier'];
			$infos['pallier']=$answer['pallier'];
			$infos['interetwei']=$answer['interetwei'];
			$infos['wei']=$answer['wei'];
			$infos['tarifwei']=$answer['tarifwei'];
			$infos['prixwei']=$answer['prixwei'];
			$infos['tarifbde']=$answer['tarifbde'];
			$infos['prixbde']=$answer['prixbde'];
			$infos['typepaiementwei']=$answer['typepaiementwei'];
			$infos['caution']=$answer['caution'];
			$infos['regime']=$answer['regime'];
			$infos['technoparade']=$answer['technoparade'];
			$infos['teeshirttechnoparade']=$answer['teeshirttechnoparade'];
			$infos['bbqsam']=$answer['bbqsam'];
			$infos['bbqdim']=$answer['bbqdim'];
			$infos['bbqlun']=$answer['bbqlun'];
			$infos['bbqmar']=$answer['bbqmar'];
			$infos['bbqmer']=$answer['bbqmer'];
			$infos['bbqjeu']=$answer['bbqjeu'];
			$infos['bbqpaye']=$answer['bbqpaye'];		
		}
		else
		{
			if(empty($_POST['nom'])){header('Refresh: 0; url=etape1.php');}else{$infos['nom']=$_POST['nom'];}
			if(empty($_POST['prenom'])){header('Refresh: 0; url=etape1.php');}else{$infos['prenom']=$_POST['prenom'];}
			if(empty($_POST['ecole'])){header('Refresh: 0; url=etape1.php');}else{$infos['ecole']=$_POST['ecole'];};
		}
		?>
		<div id="Full">
		<div id="Bandeau">
        	<img src="img_src/logo_hypnoz.png" alt="" id="logo" width="172" height="100" />
		<div id="Menu">
		<ul class="menu">
			<li class="element_menu"><a href='index.php'>Accueil</a></li>
			<li class="element_menu"><a href='stats.php'>Stats</a></li>
			<li class="element_menu"><a href='compta.php'>Compta</a></li>
			<li class="element_menu"><a href='deco.php'>Se deco</a></li>
			</ul>
		</div>
		</div>
		<div id="Contenu">
		<div id="center">
		<form method="post" action="register.php" id="formulaire">
		<fieldset>
		<legend>Informations générales</legend>
		<p>
		<br/> <span class='obligatoire'>*: Réponse obligatoire</span><br/><br/>
		<?php if(!empty($infos['id'])){?><input type="hidden" name="id" <?php echo 'value="'.$answer['id'].'"'; ?>/><?php }?>
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
		if(!empty($infos['id'])){
		if($infos['sexe'] == 'm'){ 
				echo 'checked="checked"';
			} 
			}
		?>
		/>
		
		<label class="radio" for="homme">Homme<span class='obligatoire'>*</span></label>
		<input type="radio" class="radio" name="sexe" id="f" value="f" 
		<?php
		if(!empty($infos['id'])){		
		if($infos['sexe'] == 'f'){ 
				echo 'checked="checked"';
			}
			}
		?>/><label class="radio" for="femme">Femme<span class='obligatoire'>*</span></label>
		<br/><br/>
		
		<input type="radio" class="radio" name="promo" id="1annee" value="2011" 
		<?php 
		if(!empty($infos['id'])){ //cas du mode édition
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
		?>/>
		<label class="radio" for="2annee">2ème année<span class='obligatoire'>*</span></label>
		
		<input type="radio" class="radio" name="promo" id="master" value="2009" 
		<?php 
		if(!empty($infos['id'])){ //cas du mode édition
			if($infos['promo'] == '2009'){ 
				echo 'checked="checked"';
			}
		} 
		?>/>
		<label class="radio" for="master">Master<span class='obligatoire'>*</span></label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		<br/><br/>
		<label for="nom">Nom<span class='obligatoire'>*</span> : </label>
		<input type="text" name="nom" id="nom" <?php echo 'value="'.$infos['nom'].'"';?>/><br/>
		<label for="prenom">Prénom<span class='obligatoire'>*</span> : </label><input type="text" name="prenom" id="prenom" <?php echo 'value="'.$infos['prenom'].'"';?>/><br/>
		<label for="datenaissance">Date de naissance<span class='obligatoire'>*</span> : </label><input type="text" name="datenaissance" id="datenaissance" <?php if(!empty($infos['id'])){echo 'value="'.$infos['datenaissance'].'"';}?>/><br/>
		<label for="lieunaissance">Lieu de naissance<span class='obligatoire'>*</span> : </label><input type="text" name="lieunaissance" id="lieunaissance" <?php if(!empty($infos['id'])){echo 'value="'.$infos['lieunaissance'].'"';}?>/><br/>
		<label for="portable">Portable<span class='obligatoire'>* (au choix)</span> : </label><input type="text" name="portable" id="portable" <?php if(!empty($infos['id'])){echo 'value="'.$infos['portable'].'"';}?>/><br/>
		<label for="fixe">Fixe<span class='obligatoire'>* (au choix)</span> : </label><input type="text" name="fixe" id="fixe" <?php if(!empty($infos['id'])){echo 'value="'.$infos['fixe'].'"';}?>/><br/>
		<label for="adresse">Adresse : </label><input type="text" name="adresse" id="adresse" <?php if(!empty($infos['id'])){echo 'value="'.$infos['adresse'].'"';}?>/><br/>
		<label for="s2ia">Login s2ia : </label><input type="text" name="s2ia" id="s2ia" <?php if(!empty($infos['id'])){echo 'value="'.$infos['s2ia'].'"';}?>/><br/>
		<label for="email">Adresse Email Exterieure : </label><input type="text" name="email" id="email" <?php if(!empty($infos['id'])){echo 'value="'.$infos['email'].'"';}?>/><br/>
		</p>
		</fieldset>
		<fieldset>
		<legend>Formulaire de rentrée</legend>
		<p>
		<input type="checkbox" name="ficherentree" id="ficherentree" <?php if(!empty($infos['id'])){if($infos['ficherentree']=='oui'){echo 'checked="checked"';}} ?> /><label for="ficherentree">N'a pas transmis la fiche de renseignements BDE </label><br/><br/>
		<br/>
		<input type="checkbox" name="interetsg" id="interetsg" <?php if(!empty($infos['id'])){if($infos['interetsg']=='oui'){echo 'checked="checked"';}} ?> /><label for="interetsg">Interessé par l'ouverture d'un compte SoGé </label><br/><br/>
		<input type="checkbox" name="interetwei" id="interetwei" <?php if(!empty($infos['id'])){if($infos['interetwei']=='oui'){echo 'checked="checked"';}} ?> /><label for="interetwei">Interessé par le WEI </label><br/><br/>
		<br/>
		<input type="checkbox" name="bbqsam" id="bbqsam" onClick="calcul_bbq();" <?php if(!empty($infos['id'])){if($infos['bbqsam']=='oui'){echo 'checked="checked"';}} ?>/><label for="bbqsam">Barbecue du Samedi 3</label><br/>
		<input type="checkbox" name="bbqdim" id="bbqdim" onClick="calcul_bbq();" <?php if(!empty($infos['id'])){if($infos['bbqdim']=='oui'){echo 'checked="checked"';}} ?>/><label for="bbqdim">Barbecue du Dimanche 4</label><br/>
		<input type="checkbox" name="bbqlun" id="bbqlun" onClick="calcul_bbq();" <?php if(!empty($infos['id'])){if($infos['bbqdim']=='oui'){echo 'checked="checked"';}} ?>/><label for="bbqlun">Barbecue du Lundi 5</label><br/>
		<input type="checkbox" name="bbqmar" id="bbqmar" onClick="calcul_bbq();" <?php if(!empty($infos['id'])){if($infos['bbqmar']=='oui'){echo 'checked="checked"';}} ?>/><label for="bbqmar">Barbecue du Mardi 6</label><br/>
		<input type="checkbox" name="bbqmer" id="bbqmer" onClick="calcul_bbq();" <?php if(!empty($infos['id'])){if($infos['bbqmer']=='oui'){echo 'checked="checked"';}} ?>/><label for="bbqmer">Barbecue du Mercredi 7</label><br/>
		<input type="checkbox" name="bbqjeu" id="bbqjeu" onClick="calcul_bbq();" <?php if(!empty($infos['id'])){if($infos['bbqjeu']=='oui'){echo 'checked="checked"';}} ?>/><label for="bbqjeu">Barbecue du Jeudi 8</label><br/>
		<input type="checkbox" name="bbqpaye" id="bbqpaye" onClick="calcul_bbq();" <?php if(!empty($infos['id'])){if($infos['bbqpaye']=='oui'){echo 'checked="checked"';}} ?>/><label for="bbqpaye">Barbecues payés</label><br/><div id="prixbbq" ></div></p>
		</p>
		
		</fieldset>
		<fieldset>
		<legend>Démarches administratives</legend>
		<p>
		<input type="checkbox" name="cotisantbde" id="cotisantbde" onClick="enable('cotisantbde','tarif_bde')" <?php if(!empty($infos['id'])){if($infos['cotisantbde']=='oui'){echo 'checked="checked"';}} ?> /><label for="cotisantbde">Cotisant BDE </label><br/>
		<fieldset id="tarif_bde" 
		<?php if(!empty($infos['id']))
			{
				if($infos['cotisantbde']=='oui')
				{
					echo ' disabled="enabled"';
				}
			}
			else
			{	
				echo ' disabled="disabled"';
			} ?>>
		<legend>Si cotisant</legend>
		<label for="tarifbde">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tarif appliqué:</label>
		<input type="radio" class="radio" name="tarifbde" id="bde_1a" value="<?php echo $bde_1a_officiel;?>" <?php if(!empty($infos['id'])){if($infos['tarifbde']=='1a'){echo 'checked="checked"';}} ?> />
		<label class="radio"  for="wei_1a">1A non boursier 100€</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio"  class="radio" name="tarifbde" id="bde_1abousier" value="<?php echo $bde_1aboursier_officiel;?>" <?php if(!empty($infos['id'])){if($infos['tarifbde']=='1a boursier'){echo 'checked="checked"';}} ?> />
		<label class="radio" for="wei_1aboursier">1A boursier 80€</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio"  class="radio" name="tarifbde" id="bde_ast2" value="<?php echo $bde_ast2_officiel;?>" <?php if(!empty($infos['id'])){if($infos['tarifbde']=='ast2'){echo 'checked="checked"';}} ?> />
		<label class="radio" for="wei_ast2">AST2 50€</label>
		
		<input type="radio"  class="radio" name="tarifbde" id="bde_perso" value="-1" onClick="enable('bde_perso','prixBde')"<?php if(!empty($infos['id'])){if($infos['tarifbde']=='perso'){echo 'checked="checked"';}} ?> />
		<label class="radio" for="perso">Tarif spécial:<input type="text" name="prixbde" id="prixbde" <?php if(!empty($infos['id'])){if($infos['tarifbde']=='perso'){echo 'value="'.$infos['prixbde'].'"';}} ?> /></label>
		<br/>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mode de paiement :
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
		</fieldset>
		<br/><br/>
		
		<input type="checkbox" name="comptesg" id="comptesg" onClick="enable('comptesg','clef_b');enable('comptesg','clef_g');enable('comptesg','clef_c');enable('comptesg','clef_r');" <?php if(!empty($infos['id'])){if($infos['comptesg']=='oui'){echo 'checked="checked"';}} ?>/><label for="comptesg">A crée un compte Société Générale </label><br/>
		<label for="rib">Si oui, RIB: </label><input type="text" name="clef_b" id="clef_b" size="5" maxlength="5" onKeyup="clef_rib();" <?php if(!empty($infos['id'])){echo 'value="'.$infos['clef_b'].'"';}else{echo 'value="30003"';echo ' disabled="true"';}?> /> <input type="text" name="clef_g" size="5" maxlength="5" id="clef_g" onKeyup="clef_rib()" <?php if(!empty($infos['id'])){echo 'value="'.$infos['clef_g'].'"';echo ' disabled="true"';}?> /> <input type="text" name="clef_c" id="clef_c" size="12" maxlength="11" onKeyup="clef_rib();" <?php if(!empty($infos['id'])){echo 'value="'.$infos['clef_c'].'"';echo ' disabled="true"';}?>/> <input type="text" name="clef_r" id="clef_r" size="2" maxlength="2" onKeyup="clef_rib();" <?php if(!empty($infos['id'])){echo 'value="'.$infos['clef_r'].'"';echo ' disabled="true"';}?> /> <div id="verif_rib_incomplet">Rib incomplet</div><div id="verif_rib_vrai">Rib correct</div><div id="verif_rib_faux">Rib erroné</div><br/>
		
		<input type="checkbox" name="prelevement" id="prelevement" <?php if(!empty($infos['id'])){if($infos['prelevement']=='oui'){echo 'checked="checked"';}} ?> /><label for="prelevement">Autorisation de prélèvement remplie </label><br/><br/>
		
		<input type="checkbox" name="boursier" id="boursier" onClick="enable('boursier','pallier')" <?php if(!empty($infos['id'])){if($infos['boursier']=='oui'){echo 'checked="checked"';}} ?> /><label for="boursier">Boursier </label><br/>
		<label for="pallier">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Si oui, pallier de la bourse</label><input type="text" name="pallier" id="pallier"  <?php if(!empty($infos['id'])){if($infos['boursier']=='oui'){echo 'value="'.$infos['pallier'].'"';} else{ echo 'disabled="disabled"';}} ?> /><br/><br/>
		</p>
		</fieldset>

		<fieldset>
		<legend>Informations concernant la SEI et le WEI</legend>
		<p>
		<input type="checkbox" name="wei" id="wei" onClick="enable('wei','tarif_wei')" <?php if(!empty($infos['id'])){if($infos['wei']=='oui'){echo 'checked="checked"';}} ?> /><label for="wei">Inscrit au WEI </label><br/>
		<fieldset id="tarif_wei" 
		<?php if(!empty($infos['id']))
			{
				if($infos['wei']=='oui')
				{
					echo ' disabled="enabled"';
				}
			}
			else
			{	
				echo ' disabled="disabled"';
			} ?>>
		<legend>Si oui</legend>
		<label for="prixWei">Si oui, tarif appliqué:</label>
		<input type="radio" class="radio" name="tarifwei" id="wei_1a" value="<?php echo $wei_1a_officiel;?>" <?php if(!empty($infos['id'])){if($infos['tarifwei']=='1a'){echo 'checked="checked"';}} ?> />
		<label class="radio"  for="wei_1a">1A non boursier 100€</label>
		<input type="radio"  class="radio" name="tarifwei" id="wei_1abousier" value="<?php echo $wei_1aboursier_officiel;?>" <?php if(!empty($infos['id'])){if($infos['tarifwei']=='1a boursier'){echo 'checked="checked"';}} ?> />
		<label class="radio" for="wei_1aboursier">1A boursier 80€</label>
		<input type="radio"  class="radio" name="tarifwei" id="wei_ast2" value="<?php echo $wei_ast2_officiel;?>" <?php if(!empty($infos['id'])){if($infos['tarifwei']=='ast2'){echo 'checked="checked"';}} ?> />
		<label class="radio" for="wei_ast2">AST2 50€</label>
		
		<input type="radio"  class="radio" name="tarifwei" id="wei_perso" value="-1" onClick="enable('wei_perso','prixWei')" <?php if(!empty($infos['id'])){if($infos['tarifwei']=='perso'){echo 'checked="checked"';}} ?> />
		<label class="radio" for="prixwei">Tarif spécial:<input type="text" name="prixwei" id="prixwei" <?php if(!empty($infos['id'])){if($infos['tarifwei']=='perso'){echo 'value="'.$infos['prixwei'].'"';}} ?> /></label>
		<br/>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Paiement :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		<input type="radio" class="radio" name="typepaiementwei" id="prelevementwei" value="prelevement" <?php if(!empty($infos['id'])){if($infos['wei']=='oui'){if($infos['typepaiementwei'] == 'prelevement'){echo 'checked="checked"';}} else{ echo 'disabled="disabled"';}} ?>  />
		<label class="radio" for="prelevementWei">Prélèvement</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		<input type="radio" class="radio" name="typepaiementwei" id="chequewei" value="cheque" <?php if(!empty($infos['id'])){if($infos['wei']=='oui'){if($infos['typepaiementwei'] == 'cheque'){echo 'checked="checked"';}} else{ echo 'disabled="disabled"';}} ?> />
		<label class="radio"  for="chequeWei">Chèque</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio"  class="radio" name="typepaiementwei" id="liquidewei" value="liquide" <?php if(!empty($infos['id'])){if($infos['wei']=='oui'){if($infos['typepaiementwei'] == 'liquide'){echo 'checked="checked"';}} else{ echo 'disabled="disabled"';}} ?> />
		<label class="radio" for="liquideWei">Liquide</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio"  class="radio" name="typepaiementwei" id="nonpayewei" value="nonpaye" <?php if(!empty($infos['id'])){if($infos['wei']=='oui'){if($infos['typepaiementwei'] == 'nonpaye'){echo 'checked="checked"';}} else{ echo 'disabled="disabled"';}} ?> />
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
		<br/><br/>
		</p>
		</fieldset>
		<fieldset>
		<legend>Renseignements supplémentaires</legend>
		<p>
		<input type="checkbox" name="technoparade" id="technoparade" <?php if(!empty($infos['id'])){if($infos['technoparade']=='oui'){echo 'checked="checked"';}} ?>/><label for="technoparade">Viendra à la Technoparade </label><br/>
		<input type="checkbox" name="teeshirttechnoparade" id="teeshirttechnoparade" <?php if(!empty($infos['id'])){if($infos['teeshirttechnoparade']=='oui'){echo 'checked="checked"';}} ?> /><label for="teeshirttechnoparade">Achètera le Tshirt de la Technoparade </label><br/>
		</fieldset>
		<p>
		<input type="submit" class="submit" value="<?php if(!empty($infos['id'])){ echo'Mettre &agrave; jour la fiche du nainA';} else{echo 'Ajouter le NainA &agrave; la base de donn&eacute;es';} ?>" />
		</p>
		</form>
		</div>
		</div>
		</div>
		<?php
	}
	else
	{
		?>
		<form method="post" action="index.php">
		<p>
		<label for="login">Login : </label><input type="text" name="login" /><br/>
		<label for="password">Mot de passe : </label><input type="password" name="password" /><br/>
		<input type="submit" class="submit" value="Log Me Now" /><br/>
		</p>
		</form>
		<?php	
	}

?>
</body>
</html>