<?php
//Inclusion de la fonction d'authentification
include('assets/connect/auth.php');
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
<title>Appli web de la rentrée - Hypnoz - Statistiques générales</title>
</head>
	<body>
	        <?php include'assets/includes/menu.php' ?>
	        <div id="fiche">
				<?php
				include('assets/connect/connect_settings.php');
				include('assets/includes/tarifs.php');

				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);

				$query=$bdd->prepare('SELECT * FROM '.$stats_table.' WHERE type = \'ecole\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['tsp']=$answer['nb_gauche'];
					$infos['tem']=$answer['nb_droite'];
						$infos['pc_tsp']=$answer['pc_gauche'];
							$infos['pc_tem']=$answer['pc_droite'];
								$infos['total']=$answer['total'];

				$query=$bdd->prepare('SELECT * FROM '.$stats_table.' WHERE type = \'sexe\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['garcon']=$answer['nb_gauche'];
					$infos['fille']=$answer['nb_droite'];
						$infos['pc_garcon']=$answer['pc_gauche'];
							$infos['pc_fille']=$answer['pc_droite'];

				$query=$bdd->prepare('SELECT COUNT(*) AS p2011 FROM '.$nainsa_table.' WHERE promo = \'2011\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['p2011']=$answer['p2011'];

				$query=$bdd->prepare('SELECT COUNT(*) AS p2010 FROM '.$nainsa_table.' WHERE promo = \'2010\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['p2010']=$answer['p2010'];

				$query=$bdd->prepare('SELECT COUNT(*) AS p2009 FROM '.$nainsa_table.' WHERE promo = \'2009\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['p2009']=$answer['p2009'];

				$query=$bdd->prepare('SELECT COUNT(*) AS ficherentree FROM '.$nainsa_table.' WHERE ficherentree = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['ficherentree']=$answer['ficherentree'];

				$query=$bdd->prepare('SELECT COUNT(*) AS cotisantbde FROM '.$nainsa_table.' WHERE cotisantbde = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['cotisantbde']=$answer['cotisantbde'];

				$query=$bdd->prepare('SELECT COUNT(*) AS liquidebde FROM '.$nainsa_table.' WHERE typepaiementcotiz = \'liquide\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['liquidebde']=$answer['liquidebde'];

				$query=$bdd->prepare('SELECT COUNT(*) AS chequebde FROM '.$nainsa_table.' WHERE typepaiementcotiz = \'cheque\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['chequebde']=$answer['chequebde'];

				$query=$bdd->prepare('SELECT COUNT(*) AS prelevementbde FROM '.$nainsa_table.' WHERE typepaiementcotiz = \'prelevement\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['prelevementbde']=$answer['prelevementbde'];

				$query=$bdd->prepare('SELECT COUNT(*) AS interetsg FROM '.$nainsa_table.' WHERE interetsg = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['interetsg']=$answer['interetsg'];

				$query=$bdd->prepare('SELECT COUNT(*) AS comptesg FROM '.$nainsa_table.' WHERE comptesg = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['comptesg']=$answer['comptesg'];

				$query=$bdd->prepare('SELECT COUNT(*) AS interetwei FROM '.$nainsa_table.' WHERE interetwei = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['interetwei']=$answer['interetwei'];

				$query=$bdd->prepare('SELECT COUNT(*) AS wei FROM '.$nainsa_table.' WHERE wei = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['wei']=$answer['wei'];

				$query=$bdd->prepare('SELECT COUNT(*) AS boursier FROM '.$nainsa_table.' WHERE boursier = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['boursier']=$answer['boursier'];

				$query=$bdd->prepare('SELECT COUNT(*) AS wei_1a FROM '.$nainsa_table.' WHERE tarifwei = \'1a\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['wei_1a']=$answer['wei_1a'];

				$query=$bdd->prepare('SELECT COUNT(*) AS wei_erasmus6 FROM '.$nainsa_table.' WHERE tarifwei = \'erasmus6\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['wei_erasmus6']=$answer['wei_erasmus6'];

				$query=$bdd->prepare('SELECT COUNT(*) AS wei_erasmus12 FROM '.$nainsa_table.' WHERE tarifwei = \'erasmus12\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['wei_erasmus12']=$answer['wei_erasmus12'];

				$query=$bdd->prepare('SELECT COUNT(*) AS wei_perso FROM '.$nainsa_table.' WHERE tarifwei = \'perso\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['wei_perso']=$answer['wei_perso'];

				$query=$bdd->prepare('SELECT COUNT(*) AS bde_erasmus12 FROM '.$nainsa_table.' WHERE tarifbde = \'erasmus12\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['bde_erasmus12']=$answer['bde_erasmus12'];

				$query=$bdd->prepare('SELECT COUNT(*) AS bde_1a FROM '.$nainsa_table.' WHERE tarifbde = \'1a\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['bde_1a']=$answer['bde_1a'];

				$query=$bdd->prepare('SELECT COUNT(*) AS bde_erasmus6 FROM '.$nainsa_table.' WHERE tarifbde = \'erasmus6\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['bde_erasmus6']=$answer['bde_erasmus6'];

				$query=$bdd->prepare('SELECT COUNT(*) AS bde_perso FROM '.$nainsa_table.' WHERE tarifbde = \'perso\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['bde_perso']=$answer['bde_perso'];

				$query=$bdd->prepare('SELECT COUNT(*) AS liquidewei FROM '.$nainsa_table.' WHERE typepaiementwei = \'liquide\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['liquidewei']=$answer['liquidewei'];

				$query=$bdd->prepare('SELECT COUNT(*) AS chequewei FROM '.$nainsa_table.' WHERE typepaiementwei = \'cheque\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['chequewei']=$answer['chequewei'];

				$query=$bdd->prepare('SELECT COUNT(*) AS prelevementwei FROM '.$nainsa_table.' WHERE typepaiementwei = \'prelevement\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['prelevementwei']=$answer['prelevementwei'];

				$query=$bdd->prepare('SELECT COUNT(*) AS caution FROM '.$nainsa_table.' WHERE caution = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['caution']=$answer['caution'];

				$query=$bdd->prepare('SELECT COUNT(*) AS hallal FROM '.$nainsa_table.' WHERE regime = \'hallal\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['hallal']=$answer['hallal'];

				$query=$bdd->prepare('SELECT COUNT(*) AS cachere FROM '.$nainsa_table.' WHERE regime = \'cachere\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['cachere']=$answer['cachere'];

				$query=$bdd->prepare('SELECT COUNT(*) AS vegetarien FROM '.$nainsa_table.' WHERE regime = \'vegetarien\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['vegetarien']=$answer['vegetarien'];

				$query=$bdd->prepare('SELECT COUNT(*) AS bbqsam FROM '.$nainsa_table.' WHERE bbqsam = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['bbqsam']=$answer['bbqsam'];

				$query=$bdd->prepare('SELECT COUNT(*) AS bbqdim FROM '.$nainsa_table.' WHERE bbqdim = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['bbqdim']=$answer['bbqdim'];

				$query=$bdd->prepare('SELECT COUNT(*) AS bbqven FROM '.$nainsa_table.' WHERE bbqven = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['bbqven']=$answer['bbqven'];

				$query=$bdd->prepare('SELECT COUNT(*) AS bbqmar FROM '.$nainsa_table.' WHERE bbqmar = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['bbqmar']=$answer['bbqmar'];

				$query=$bdd->prepare('SELECT COUNT(*) AS bbqmer FROM '.$nainsa_table.' WHERE bbqmer = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['bbqmer']=$answer['bbqmer'];

				$query=$bdd->prepare('SELECT COUNT(*) AS bbqjeu FROM '.$nainsa_table.' WHERE bbqjeu = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['bbqjeu']=$answer['bbqjeu'];

				$query=$bdd->prepare('SELECT COUNT(*) AS bbqpaye FROM '.$nainsa_table.' WHERE bbqpaye = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['bbqpaye']=$answer['bbqpaye'];

				$query=$bdd->prepare('SELECT COUNT(*) AS nb_bbq FROM '.$nainsa_table.' WHERE bbqsam = \'oui\' OR bbqdim = \'oui\' OR bbqmar= \'oui\' OR bbqmer= \'oui\' OR bbqjeu= \'oui\' OR bbqven= \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['nb_bbq']=$answer['nb_bbq'];
				$infos['nb_bbqpaye']=0;

				$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE bbqpaye = \'oui\';');
				$query->execute();

				while($answer=$query->fetch()) {
					if($answer['bbqsam']=='oui'){$infos['nb_bbqpaye']=$infos['nb_bbqpaye']+1;}
						if($answer['bbqdim']=='oui'){$infos['nb_bbqpaye']=$infos['nb_bbqpaye']+1;}
							if($answer['bbqven']=='oui'){$infos['nb_bbqpaye']=$infos['nb_bbqpaye']+1;}
								if($answer['bbqmar']=='oui'){$infos['nb_bbqpaye']=$infos['nb_bbqpaye']+1;}
									if($answer['bbqmer']=='oui'){$infos['nb_bbqpaye']=$infos['nb_bbqpaye']+1;}
										if($answer['bbqjeu']=='oui'){$infos['nb_bbqpaye']=$infos['nb_bbqpaye']+1;}
				}


				$query=$bdd->prepare('SELECT COUNT(*) AS technoparade FROM '.$nainsa_table.' WHERE technoparade = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['technoparade']=$answer['technoparade'];

				$query=$bdd->prepare('SELECT COUNT(*) AS teeshirttechnoparade FROM '.$nainsa_table.' WHERE teeshirttechnoparade = \'oui\';');
				$query->execute();
				$answer=$query->fetch();

				$infos['teeshirttechnoparade']=$answer['teeshirttechnoparade'];


				?>
					<p>
						<span class='question'>Nombre total d'inscrits: </span><span class='reponse'><?php echo $infos['total'];?></span><br/>
						<span class='question'>TSP: </span><span class='reponse'><?php echo $infos['tsp'];?> <?php echo 'soit '.$infos['pc_tsp'].'% des inscrits';?></span><br/>
						<span class='question'>TEM: </span><span class='reponse'><?php echo $infos['tem'];?> <?php echo 'soit '.$infos['pc_tem'].'% des inscrits';?></span><br/>
						<span class='question'>Filles: </span><span class='reponse'><?php echo $infos['fille'];?> <?php echo 'soit '.$infos['pc_fille'].'% des inscrits';?></span><br/>
						<span class='question'>Garçons: </span><span class='reponse'><?php echo $infos['garcon'];?> <?php echo 'soit '.$infos['pc_garcon'].'% des inscrits';?></span><br/>
						<span class='question'>Promo 2009: </span><span class='reponse'><?php echo $infos['p2009'];?></span><br/>
						<span class='question'>Promo 2010: </span><span class='reponse'><?php echo $infos['p2010'];?></span><br/>
						<span class='question'>Promo 2011: </span><span class='reponse'><?php echo $infos['p2011'];?></span><br/>
						<span class='question'>Promo 2012: </span><span class='reponse'><?php echo $infos['p2011'];?></span><br/>
					</p>
					<p>
						<span class='question'>Ont rempli la fiche rentrée: </span><span class='reponse'><?php  echo $infos['ficherentree']?> <?php echo 'soit '.round(100*$infos['ficherentree']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Cotisants BDE: </span><span class='reponse'><?php  echo $infos['cotisantbde']?> <?php echo 'soit '.round(100*$infos['cotisantbde']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Payent la cotisation par prélèvement: </span><span class='reponse'><?php  echo $infos['prelevementbde']?> <?php echo 'soit '.round(100*$infos['prelevementbde']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Payent la cotisation en liquide: </span><span class='reponse'><?php  echo $infos['liquidebde']?> <?php echo 'soit '.round(100*$infos['liquidebde']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Payent la cotisation par chèque: </span><span class='reponse'><?php  echo $infos['chequebde']?> <?php echo 'soit '.round(100*$infos['chequebde']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>N'ont pas payé la cotisation BDE: </span><span class='reponse'><?php  $res=$infos['total']-($infos['chequebde']+$infos['liquidebde']+$infos['prelevementbde']); echo $res;?> <?php echo 'soit '.round(100*$res/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Nombre de cotisant au tarif 1a: </span><span class='reponse'><?php  echo $infos['bde_1a'];?> <?php echo 'soit '.round(100*$infos['bde_1a']/$infos['cotisantbde']).'% des cotisants';?></span><br/>
						<span class='question'>Nombre de cotisant au tarif Erasmus 6 mois: </span><span class='reponse'><?php  echo $infos['bde_erasmus6'];?> <?php echo 'soit '.round(100*$infos['bde_erasmus6']/$infos['cotisantbde']).'% des cotisants';?></span><br/>
						<span class='question'>Nombre de cotisant au tarif Erasmus 1 an: </span><span class='reponse'><?php  echo $infos['bde_erasmus12'];?> <?php echo 'soit '.round(100*$infos['bde_erasmus12']/$infos['cotisantbde']).'% des cotisants';?></span><br/>
						<span class='question'>Nombre de cotisant au tarif perso: </span><span class='reponse'><?php  echo $infos['bde_perso'];?> <?php echo 'soit '.round(100*$infos['bde_perso']/$infos['cotisantbde']).'% des cotisants';?></span><br/>
						<span class='question'>Intéressés par l'ouverture d'un compte Sogé: </span><span class='reponse'><?php  echo $infos['interetsg']?> <?php echo 'soit '.round(100*$infos['interetsg']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Titulaires d'un compte Sogé: </span><span class='reponse'><?php  echo $infos['comptesg']?> <?php echo 'soit '.round(100*$infos['comptesg']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Boursiers: </span><span class='reponse'><?php  echo $infos['boursier']?> <?php echo 'soit '.round(100*$infos['boursier']/$infos['total']).'% des inscrits';?></span><br/>
					</p>
					<p>
						<span class='question'>Intéressés par le wei: </span><span class='reponse'><?php  echo $infos['interetwei']?> <?php echo 'soit '.round(100*$infos['interetwei']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Inscrits au wei: </span><span class='reponse'><?php  echo $infos['wei']?> <?php echo 'soit '.round(100*$infos['wei']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Payent par chèque: </span><span class='reponse'><?php  echo $infos['chequebde']?> <?php echo 'soit '.round(100*$infos['chequebde']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Payent le wei par prélèvement: </span><span class='reponse'><?php  echo $infos['prelevementwei']?> <?php echo 'soit '.round(100*$infos['prelevementwei']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Payent le wei en liquide: </span><span class='reponse'><?php  echo $infos['liquidewei']?> <?php echo 'soit '.round(100*$infos['liquidewei']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Payent le wei par chèque: </span><span class='reponse'><?php  echo $infos['chequewei']?> <?php echo 'soit '.round(100*$infos['chequewei']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Nombre d'inscrits au Wei au tarif 1a: </span><span class='reponse'><?php  echo $infos['wei_1a'];?> <?php echo 'soit '.round(100*$infos['wei_1a']/$infos['wei']).'% des inscrits au wei';?></span><br/>
						<span class='question'>Nombre d'inscrits au Wei au tarif Erasmus 6 mois: </span><span class='reponse'><?php  echo $infos['wei_erasmus6'];?> <?php echo 'soit '.round(100*$infos['wei_erasmus6']/$infos['wei']).'% des inscrits au wei';?></span><br/>
						<span class='question'>Nombre d'inscrits au Wei au tarif Erasmus 1 an: </span><span class='reponse'><?php  echo $infos['wei_erasmus12'];?> <?php echo 'soit '.round(100*$infos['wei_erasmus12']/$infos['wei']).'% des inscrits au wei';?></span><br/>
						<span class='question'>Nombre d'inscrits au Wei au tarif perso: </span><span class='reponse'><?php  echo $infos['wei_perso'];?> <?php echo 'soit '.round(100*$infos['wei_perso']/$infos['wei']).'% des inscrits au wei';?></span><br/>
						<span class='question'>Cautions versées: </span><span class='reponse'><?php  echo $infos['caution']?> <?php echo 'soit '.round(100*$infos['caution']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Intéressés par la Technoparade: </span><span class='reponse'><?php  echo $infos['technoparade']?> <?php echo 'soit '.round(100*$infos['technoparade']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Intéressés par un Tee-shirt de la Technoparade: </span><span class='reponse'><?php  echo $infos['teeshirttechnoparade']?> <?php echo 'soit '.round(100*$infos['teeshirttechnoparade']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Hallal: </span><span class='reponse'><?php  echo $infos['hallal']?> <?php echo 'soit '.round(100*$infos['hallal']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Cachere: </span><span class='reponse'><?php  echo $infos['cachere']?> <?php echo 'soit '.round(100*$infos['cachere']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Végétariens: </span><span class='reponse'><?php  echo $infos['vegetarien']?> <?php echo 'soit '.round(100*$infos['vegetarien']/$infos['total']).'% des inscrits';?></span><br/>
					</p>
					<p>
						<span class='question'>Barbeucs du samedi: </span><span class='reponse'><?php  echo $infos['bbqsam']?> <?php echo 'soit '.round(100*$infos['bbqsam']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Barbeucs du dimanche: </span><span class='reponse'><?php  echo $infos['bbqdim']?> <?php echo 'soit '.round(100*$infos['bbqdim']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Barbeucs du mardi: </span><span class='reponse'><?php  echo $infos['bbqmar']?> <?php echo 'soit '.round(100*$infos['bbqmar']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Barbeucs du mercredi: </span><span class='reponse'><?php  echo $infos['bbqmer']?> <?php echo 'soit '.round(100*$infos['bbqmer']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Barbeucs du jeudi: </span><span class='reponse'><?php  echo $infos['bbqjeu']?> <?php echo 'soit '.round(100*$infos['bbqjeu']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Brunch du vendredi: </span><span class='reponse'><?php  echo $infos['bbqven']?> <?php echo 'soit '.round(100*$infos['bbqven']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Ont payé leurs Barbeucs: </span><span class='reponse'><?php  echo $infos['bbqpaye']?> <?php echo 'soit '.round(100*$infos['bbqpaye']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Nombre moyen de Barbeucs: </span><span class='reponse'><?php  $res=round(($infos['bbqsam']+$infos['bbqdim']+$infos['bbqven']+$infos['bbqmar']+$infos['bbqmer']+$infos['bbqjeu'])/$infos['total'],2);echo $res?> <?php echo 'soit '.round($res*5,2).'€ dépensés par personne';?></span><br/>
						<span class='question'>Nombre de personnes allant au moins à un Barbeucs: </span><span class='reponse'><?php  echo $infos['nb_bbq']?> <?php echo 'soit '.round(100*$infos['nb_bbq']/$infos['total']).'% des inscrits';?></span><br/>
						<span class='question'>Nombre de barbeucs payés: </span><span class='reponse'><?php  echo $infos['nb_bbqpaye']?> sur <?php $addition=$infos['bbqsam']+$infos['bbqdim']+$infos['bbqven']+$infos['bbqmar']+$infos['bbqmer']+$infos['bbqjeu'];echo $addition; ?> <?php echo 'soit '.round(100*$infos['nb_bbqpaye']/($infos['bbqsam']+$infos['bbqdim']+$infos['bbqven']+$infos['bbqmar']+$infos['bbqmer']+$infos['bbqjeu'])).'% des barbeucs';?> soit encore <?php $mult1=$infos['nb_bbqpaye']*5; $mult2=$addition*5; echo $mult1.'€ sur '.$mult2.'€';?></span><br/>
					</p>
		</div><!-- fin de fiche -->
		<?php }
		else {
			header('Refresh: 0; url=index.php');
		}
		?>
	</body>
</html>