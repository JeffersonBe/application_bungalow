<?php
include('assets/connect/auth.php');
$level=hothentic();
if($level)
	{
include('assets/includes/tarifs.php');

if(
	!empty($_POST['ecole']) &&
	!empty($_POST['nom']) &&
	!empty($_POST['prenom']) &&
	!empty($_POST['promo']) &&
	!empty($_POST['sexe']) &&
	!empty($_POST['portable']) &&
	$_POST['ecole'] != 'undefined' &&
	$_POST['sexe'] != 'undefined' &&
	$_POST['promo'] != 'undefined'
	){
		//champs obligatoires remplis

		$sexe = addslashes($_POST['sexe']);
		$ecole = addslashes($_POST['ecole']);
		$promo = addslashes($_POST['promo']);
		$nom_raw = addslashes($_POST['nom']);
                //Parsing du nom
                $find = array('à','â','ä','é','è','ê','ë','î','ï','ç','ù','ü','ô','ö');
                $replace = array('a','a','a','e','e','e','e','i','i','c','u','u','o','o');
                $nom = strtoupper(str_replace($find,$replace,strtolower($nom_raw)));
		$prenom_raw = addslashes($_POST['prenom']);
				//parsing du prenom
                $prenom = strtolower(str_replace($find,$replace,$prenom_raw));
		$portable = addslashes($_POST['portable']);
		if(empty($_POST['ficherentree'])){
			$ficherentree = 'non';
		}
		else{
			$ficherentree = 'oui';
		}
		if(empty($_POST['prixbde'])){
			$prixbde = 0;
		}
		else{
			$prixbde = addslashes($_POST['prixbde']);
		}
		if(empty($_POST['tarifbde'])){
			$tarifbde = 0;
		}
		else{
			$tarifbde = addslashes($_POST['tarifbde']);
		}

		if(empty($_POST['typepaiementcotiz'])){
			$typepaiementcotiz = '';
		}
		else{
			$typepaiementcotiz = addslashes($_POST['typepaiementcotiz']);
		}
		if(empty($_POST['cotisantbde'])){
			$cotisantbde = 'non';
			$typepaiementcotiz = '';
			$prixbde=0;
			$tarifbde=0;
		}
		else{
			$cotisantbde = 'oui';
		}
		if(empty($_POST['interetsg'])){
			$interetsg = 'non';
		}
		else{
			$interetsg = 'oui';
		}
				if(!empty($_POST['clef_b'])&&!empty($_POST['clef_c'])&&!empty($_POST['clef_g'])&&!empty($_POST['clef_r']))
		{
		$numcompte = addslashes($_POST['clef_b'].$_POST['clef_g'].$_POST['clef_c'].$_POST['clef_r']);
		}
		else
		{
		$numcompte='';
		}
		if(empty($_POST['comptesg'])){
			$comptesg = 'non';
			$numcompte='';
		}
		else{
			$comptesg = 'oui';
		}

		if(empty($_POST['prelevement'])){
			$prelevement = 'non';
		}
		else{
			$prelevement = 'oui';
		}

		if(empty($_POST['boursier'])){
			$boursier = 'non';
		}
		else{
			$boursier = 'oui';
		}
		if(empty($_POST['interetwei'])){
			$interetwei = 'non';
		}
		else{
			$interetwei= 'oui';
		}
		if(empty($_POST['pallier'])){
			$pallier = '';
		}
		else
		{
			$pallier = addslashes($_POST['pallier']);
		}
		if(empty($_POST['regime'])){
			$regime = '';
		}
		else{
			$regime = addslashes($_POST['regime']);
		}
		if(empty($_POST['prixwei'])){
			$prixwei = 0;
		}
		else{
			$prixwei = addslashes($_POST['prixwei']);
		}
		if(empty($_POST['tarifwei'])){
			$tarifwei = 0;
		}
		else{
			$tarifwei = addslashes($_POST['tarifwei']);
		}
		if(empty($_POST['typepaiementwei'])){
			$typepaiementwei = '';
			$tarifwei=0;
			$prixwei=0;
		}
		else{
			$typepaiementwei = addslashes($_POST['typepaiementwei']);
		}
		if(empty($_POST['interetwei'])){
			$interetwei = 'non';
		}
		else{
			$interetwei = 'oui';
		}

		if(empty($_POST['technoparade'])){
			$technoparade = 'non';
		}
		else{
			$technoparade = 'oui';
		}
		if(empty($_POST['caution'])){
			$caution = 'non';
		}
		else{
			$caution = 'oui';
		}
		if(empty($_POST['wei'])){
			$wei = 'non';
		}
		else{
			$wei = 'oui';
		}
		if(empty($_POST['teeshirttechnoparade'])){
			$teeshirttechnoparade = 'non';
		}
		else{
			$teeshirttechnoparade = 'oui';
		}

		if(empty($_POST['bbqsam'])){
			$bbqsam = 'non';
		}
		else{
			$bbqsam = 'oui';
		}
		if(empty($_POST['bbqdim'])){
			$bbqdim = 'non';
		}
		else{
			$bbqdim = 'oui';
		}
		if(empty($_POST['bbqven'])){
			$bbqven = 'non';
		}
		else{
			$bbqven = 'oui';
		}
		if(empty($_POST['bbqmar'])){
			$bbqmar = 'non';
		}
		else{
			$bbqmar = 'oui';
		}
		if(empty($_POST['bbqmer'])){
			$bbqmer = 'non';
		}
		else{
			$bbqmer = 'oui';
		}
		if(empty($_POST['bbqjeu'])){
			$bbqjeu = 'non';
		}
		else{
			$bbqjeu = 'oui';
		}
		if(empty($_POST['bbqpaye'])){
			$bbqpaye = 'non';
		}
		else{
			$bbqpaye = 'oui';
		}
		$s2ia=addslashes($_POST['s2ia']);
		$email=addslashes($_POST['email']);
		$adresse=addslashes($_POST['adresse']);
		//On se connecte
		$modification=time();
		$creation=time();
		include('connect/connect_settings.php');
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
		if(empty($_POST['id']))
		{
					//Création de la fiche
					$query=$bdd->prepare('INSERT INTO '.$nainsa_table.' (
					nom,
					prenom,
					ecole,
					sexe,
					promo,
					s2ia,
					email,
					portable,
					adresse,
					ficherentree ,
					cotisantbde ,
					typepaiementcotiz,
					interetsg ,
					comptesg ,
					numcompte ,
					prelevement,
					boursier,
					pallier,
					interetwei,
					wei,
					tarifwei,
					prixwei,
					tarifbde,
					prixbde,
					typepaiementwei,
					caution,
					regime,
					technoparade,
					teeshirttechnoparade,
					bbqsam,
					bbqdim,
					bbqven,
					bbqmar,
					bbqmer,
					bbqjeu,
					bbqpaye,
					creation,
					modification,
					reservationbungalow
					) VALUES (
					:r_nom,
					:r_prenom,
					:r_ecole,
					:r_sexe,
					:r_promo,
					:r_s2ia,
					:r_email,
					:r_portable,
					:r_adresse,
					:r_ficherentree ,
					:r_cotisantbde ,
					:r_typepaiementcotiz,
					:r_interetsg ,
					:r_comptesg ,
					:r_numcompte ,
					:r_prelevement,
					:r_boursier,
					:r_pallier,
					:r_interetwei,
					:r_wei,
					:r_tarifwei,
					:r_prixwei,
					:r_tarifbde,
					:r_prixbde,
					:r_typepaiementwei,
					:r_caution,
					:r_regime,
					:r_technoparade,
					:r_teeshirttechnoparade,
					:r_bbqsam,
					:r_bbqdim,
					:r_bbqven,
					:r_bbqmar,
					:r_bbqmer,
					:r_bbqjeu,
					:r_bbqpaye,
					DATE_ADD(NOW(), INTERVAL 6 HOUR),
					DATE_ADD(NOW(), INTERVAL 6 HOUR),
					0
					);');
			if($query->execute(array(
			'r_nom' => $nom,
			'r_prenom' => $prenom,
			'r_promo' => $promo,
			'r_ecole' => $ecole,
			'r_sexe' => $sexe,
			'r_s2ia' => $s2ia,
			'r_email' => $email,
			'r_portable' => $portable,
			'r_adresse' => $adresse,
			'r_ficherentree' => $ficherentree,
			'r_cotisantbde' => $cotisantbde,
			'r_typepaiementcotiz' => $typepaiementcotiz,
			'r_interetsg' => $interetsg,
			'r_comptesg' => $comptesg,
			'r_numcompte' => $numcompte,
			'r_prelevement' => $prelevement,
			'r_boursier' => $boursier,
			'r_pallier' => $pallier,
			'r_interetwei' => $interetwei,
			'r_wei' => $wei,
			'r_tarifwei' => $tarifwei,
			'r_prixwei' => $prixwei,
			'r_tarifbde' => $tarifbde,
			'r_prixbde' => $prixbde,
			'r_typepaiementwei' => $typepaiementwei,
			'r_caution' => $caution,
			'r_regime' => $regime,
			'r_technoparade' => $technoparade,
			'r_teeshirttechnoparade' => $teeshirttechnoparade,
			'r_bbqsam' => $bbqsam,
			'r_bbqdim' => $bbqdim,
			'r_bbqven' => $bbqven,
			'r_bbqmar' => $bbqmar,
			'r_bbqmer' => $bbqmer,
			'r_bbqjeu' => $bbqjeu,
			'r_bbqpaye' => $bbqpaye,
			))){$msg=1;}else{$msg=0;};
			}
			else
			{
							$id=addslashes($_POST['id']);
								//Modification de la fiche
								$query=$bdd->prepare('SELECT ecole,sexe FROM '.$nainsa_table.' WHERE id= :r_id;');
								$query->execute(array(':r_id'=>$id));
								$answer=$query->fetch();
								$oldsexe=$answer['sexe'];
								$oldecole=$answer['ecole'];

					$query=$bdd->prepare('UPDATE '.$nainsa_table.' SET
					nom=:r_nom,
					prenom=:r_prenom,
					ecole=:r_ecole,
					sexe=:r_sexe,
					promo=:r_promo,
					s2ia=:r_s2ia,
					email=:r_email,
					portable=:r_portable,
					adresse=:r_adresse,
					ficherentree=:r_ficherentree ,
					cotisantbde=:r_cotisantbde ,
					typepaiementcotiz=:r_typepaiementcotiz,
					interetsg=:r_interetsg ,
					comptesg=:r_comptesg ,
					numcompte=:r_numcompte ,
					prelevement=:r_prelevement,
					boursier=:r_boursier,
					pallier=:r_pallier,
					interetwei=:r_interetwei,
					wei=:r_wei,
					tarifwei=:r_tarifwei,
					prixwei=:r_prixwei,
					tarifbde=:r_tarifbde,
					prixbde=:r_prixbde,
					typepaiementwei=:r_typepaiementwei,
					caution=:r_caution,
					regime=:r_regime,
					technoparade=:r_technoparade,
					teeshirttechnoparade=:r_teeshirttechnoparade,
					bbqsam=:r_bbqsam,
					bbqdim=:r_bbqdim,
					bbqven=:r_bbqven,
					bbqmar=:r_bbqmar,
					bbqmer=:r_bbqmer,
					bbqjeu=:r_bbqjeu,
					bbqpaye=:r_bbqpaye,
					modification= DATE_ADD(NOW(), INTERVAL 6 HOUR)
					 WHERE id=:r_id;');
			if($query->execute(array(
			'r_nom' => $nom,
			'r_prenom' => $prenom,
			'r_promo' => $promo,
			'r_ecole' => $ecole,
			'r_sexe' => $sexe,
			'r_s2ia' => $s2ia,
			'r_email' => $email,
			'r_portable' => $portable,
			'r_adresse' => $adresse,
			'r_ficherentree' => $ficherentree,
			'r_cotisantbde' => $cotisantbde,
			'r_typepaiementcotiz' => $typepaiementcotiz,
			'r_interetsg' => $interetsg,
			'r_comptesg' => $comptesg,
			'r_numcompte' => $numcompte,
			'r_prelevement' => $prelevement,
			'r_boursier' => $boursier,
			'r_pallier' => $pallier,
			'r_interetwei' => $interetwei,
			'r_wei' => $wei,
			'r_tarifwei' => $tarifwei,
			'r_prixwei' => $prixwei,
			'r_tarifbde' => $tarifbde,
			'r_prixbde' => $prixbde,
			'r_typepaiementwei' => $typepaiementwei,
			'r_caution' => $caution,
			'r_regime' => $regime,
			'r_technoparade' => $technoparade,
			'r_teeshirttechnoparade' => $teeshirttechnoparade,
			'r_bbqsam' => $bbqsam,
			'r_bbqdim' => $bbqdim,
			'r_bbqven' => $bbqven,
			'r_bbqmar' => $bbqmar,
			'r_bbqmer' => $bbqmer,
			'r_bbqjeu' => $bbqjeu,
			'r_bbqpaye' => $bbqpaye,
			'r_id' => $id
			)))
			{$msg=2;}
			else{$msg=0;}}
			if($msg){
				if($msg==1)
				{
				// On mets à jour les stats
				//D'abord les stats filles&garçons:
				//à gauche les garçons, à droite les filles, comme sur les images de stats
				$query=$bdd->prepare('SELECT * FROM '.$stats_table.' WHERE type =\'sexe\';');
				$query->execute();
				$answer=$query->fetch();
				$nouveau_nb_garcon=$answer['nb_gauche'];
				$nouveau_nb_fille=$answer['nb_droite'];
				if($sexe=='m')
				{
					$nouveau_nb_garcon=$nouveau_nb_garcon+1;
				}
				else
				{

					$nouveau_nb_fille=$nouveau_nb_fille+1;
				}
				$pc_garcon=round(100*$nouveau_nb_garcon/($nouveau_nb_garcon+$nouveau_nb_fille),2);
				$query=$bdd->prepare('UPDATE '.$stats_table.' SET
				 pc_gauche = :r_pc_gauche,
				 pc_droite = :r_pc_droite,
				 nb_gauche = :r_nb_gauche,
				 nb_droite = :r_nb_droite,
				 total = :r_total
				 WHERE type=\'sexe\'
				 ');
				$query->execute(array(
				'r_pc_gauche'=>$pc_garcon,
				'r_pc_droite'=>100-$pc_garcon,
				'r_nb_gauche'=>$nouveau_nb_garcon,
				'r_nb_droite'=>$nouveau_nb_fille,
				'r_total'=>$nouveau_nb_fille+$nouveau_nb_garcon
				));
				//on mets à jour les images cache
				include('img_stat_sexe.php');
				img_stat_sexe($pc_garcon);

				//Ensuite les stats tem&tsp:
				//à gauche tsp, à droite tem, comme sur les images de stats
				$query=$bdd->prepare('SELECT * FROM '.$stats_table.' WHERE type=\'ecole\';');
				$query->execute();
				$answer=$query->fetch();
				$nouveau_nb_tsp=$answer['nb_gauche'];
				$nouveau_nb_tem=$answer['nb_droite'];
				if($ecole=="tsp")
				{
					$nouveau_nb_tsp=$nouveau_nb_tsp+1;
				}
				else
				{
					$nouveau_nb_tem=$nouveau_nb_tem+1;
				}
				$pc_tsp=round(100*$nouveau_nb_tsp/($nouveau_nb_tsp+$nouveau_nb_tem),2);
				$query=$bdd->prepare('UPDATE '.$stats_table.' SET
				 pc_gauche = :r_pc_gauche,
				 pc_droite = :r_pc_droite,
				 nb_gauche = :r_nb_gauche,
				 nb_droite = :r_nb_droite,
				 total = :r_total
				WHERE type=\'ecole\'
				 ');
				$query->execute(array(
				'r_pc_gauche'=>$pc_tsp,
				'r_pc_droite'=>100-$pc_tsp,
				'r_nb_gauche'=>$nouveau_nb_tsp,
				'r_nb_droite'=>$nouveau_nb_tem,
				'r_total'=>$nouveau_nb_tem+$nouveau_nb_tsp,
				));
				//on mets à jour les images cache
				include('img_stat_ecole.php');
				img_stat_ecole($pc_tsp,$nouveau_nb_tsp,$nouveau_nb_tem);
				}
				else
				{
				if($oldsexe!=$sexe)
				{
									//D'abord les stats filles&garçons:
				//à gauche les garçons, à droite les filles, comme sur les images de stats
				$query=$bdd->prepare('SELECT * FROM '.$stats_table.' WHERE type = \'sexe\';');
				$query->execute();
				$answer=$query->fetch();
				$nouveau_nb_garcon=$answer['nb_gauche'];
				$nouveau_nb_fille=$answer['nb_droite'];
				if($sexe=='m')
				{
					$nouveau_nb_garcon=$nouveau_nb_garcon+1;
					$nouveau_nb_fille=$nouveau_nb_fille-1;
				}
				else
				{
					$nouveau_nb_garcon=$nouveau_nb_garcon-1;
					$nouveau_nb_fille=$nouveau_nb_fille+1;
				}
				$pc_garcon=round(100*$nouveau_nb_garcon/($nouveau_nb_garcon+$nouveau_nb_fille),2);
				$query=$bdd->prepare('UPDATE '.$stats_table.' SET
				 pc_gauche = :r_pc_gauche,
				 pc_droite = :r_pc_droite,
				 nb_gauche = :r_nb_gauche,
				 nb_droite = :r_nb_droite
				 WHERE type=\'sexe\'
				 ');
				$query->execute(array(
				'r_pc_gauche'=>$pc_garcon,
				'r_pc_droite'=>100-$pc_garcon,
				'r_nb_gauche'=>$nouveau_nb_garcon,
				'r_nb_droite'=>$nouveau_nb_fille
				));
				//on mets à jour les images cache
				include('img_stat_sexe.php');
				img_stat_sexe($pc_garcon);
				}
				if($oldecole!=$ecole)
				{
									//Ensuite les stats tem&tsp:
				//à gauche tsp, à droite tem, comme sur les images de stats
				$query=$bdd->prepare('SELECT * FROM '.$stats_table.' WHERE type=\'ecole\';');
				$query->execute();
				$answer=$query->fetch();
				$nouveau_nb_tsp=$answer['nb_gauche'];
				$nouveau_nb_tem=$answer['nb_droite'];
				if($ecole=="tsp")
				{
					$nouveau_nb_tsp=$nouveau_nb_tsp+1;
					$nouveau_nb_tem=$nouveau_nb_tem-1;
				}
				else
				{
					$nouveau_nb_tsp=$nouveau_nb_tsp-1;
					$nouveau_nb_tem=$nouveau_nb_tem+1;
				}
				$pc_tsp=round(100*$nouveau_nb_tsp/($nouveau_nb_tsp+$nouveau_nb_tem),2);
				$query=$bdd->prepare('UPDATE '.$stats_table.' SET
				 pc_gauche = :r_pc_gauche,
				 pc_droite = :r_pc_droite,
				 nb_gauche = :r_nb_gauche,
				 nb_droite = :r_nb_droite
				WHERE type=\'ecole\'
				 ');
				$query->execute(array(
				'r_pc_gauche'=>$pc_tsp,
				'r_pc_droite'=>100-$pc_tsp,
				'r_nb_gauche'=>$nouveau_nb_tsp,
				'r_nb_droite'=>$nouveau_nb_tem
				));
				//on mets à jour les images cache
				include('img_stat_ecole.php');
				img_stat_ecole($pc_tsp,$nouveau_nb_tsp,$nouveau_nb_tem);
				}
				}
				?>
			<HEAD>
<SCRIPT language="JavaScript">
<!--
window.location="<?php echo 'index.php?msg='.urlencode($msg).'&cont='.urlencode($prenom.' '.$nom);?>";
//-->
</SCRIPT>
</HEAD>
<?php
			header('Refresh: 0; url=index.php?msg='.urlencode($msg).'&cont='.urlencode($prenom.' '.$nom));
			}
			else
			{
				header('Refresh: 0; url=etape1.php');
			}

		}
		else
		{
			echo 'Les champs dotés d\'une astérisque rouge doivent être remplis.';
		}
}
else
{
header('Refresh: 0; url=index.php');
}
?>