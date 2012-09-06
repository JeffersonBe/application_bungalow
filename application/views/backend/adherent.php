<?php echo js('showtime'); ?>
<?php
$moyen_payement_options = array(
	"" => " ",
	"prelevement" => "Prélèvement",
	"cheque" => "Chèque",
	"liquide" => "Liquide",
);
?>
<div id="main" class="row">
	<?php
	if ($adherent)
	{
	?>
		<div class="twelve columns">
			<div class="two columns">
				<?php echo anchor("backend/adherent/modifier/".$adherent->id, "Modifier", array("class" => "left button")); ?>
			</div>
			<div class="two columns">
				<?php echo anchor("backend/adherent/supprimer/".$adherent->id, "Supprimer",
					array(
						'class' => "alert button",
						'onclick' => "suppression_adherent()",
						'target' => '_blank',
					)
				); ?>
			</div><br /><br /><br />
			<div class="six columns">
				<h3>Adhérent</h3>
				<input type='button' id='voir_plus_adherent' onclick='reveal("plus_adherent", "voir_plus_adherent")' class='tiny secondary button' value="Plus d'informations »" style='margin-bottom: 10px' />
				<ul>
					<li><b>Nom</b> : <?php echo $adherent->nom; ?></li>
					<li><b>Prénom</b> : <?php echo $adherent->prenom; ?></li>
					<li><b>École</b> : 
						<?php
						$ecole = array(
							"tem" => "TEM",
							"tsp" => "TSP",
						);
						echo $ecole[$adherent->ecole];
						?>
					</li>
					<li><b>Sexe</b> : 
						<?php
						$sexe = array(
							"m" => "Homme",
							"f" => "Femme",
						);
						echo $sexe[$adherent->sexe];
						?>
					</li>
					<div id='plus_adherent'>
						<li><b>Promotion</b> : <?php echo ($adherent->promo-3)." - ".$adherent->promo ?></li>
						<li><b>Création de la fiche</b> : <?php echo $adherent->creation; ?></li>
						<li><b>Dernière modification de la fiche</b> : <?php echo $adherent->modification; ?></li>
					</div>
				</ul>
			</div>
			<div class="six columns float" id="photo" style='float: right;'>
				<?php
				if ($profil && $profil->disi)
					echo "<img src='http://trombi.it-sudparis.eu/jpegPhoto.php?dn=uid%3D".$profil->disi."%2Cou%3DPeople%2Cdc%3Dint-evry%2Cdc%3Dfr' class='right' />";
				?>
			</div>
			<div class="six columns">
				<h3>Profil</h3>
				<?php
				if ($profil)
				{
					?>
					<input type='button' id='voir_plus_profil' onclick='reveal("plus_profil", "voir_plus_profil")' class='tiny secondary button' value="Plus d'informations »" style='margin-bottom: 10px' />
					<?php
					echo "<ul>";
						if ($profil->disi)
							echo "<li><b>Login DISI</b> : ".$profil->disi."</li>";
						if ($profil->email)
							echo "<li><b>Adresse e-mail</b> : ".$profil->email."</li>";
						if ($profil->date_naissance)
							echo "<li><b>Date de naissance</b> : ".formater_date_ecran($profil->date_naissance)."</li>";
						if ($profil->portable)
							echo "<li><b>Téléphone portable</b> : ".$profil->portable."</li>";
						if ($profil->fixe)
							echo "<li><b>Téléphone fixe</b> : ".$profil->fixe."</li>";
						if ($profil->adresse)
							echo "<li><b>Adresse</b> : <br />".$profil->adresse."</li>";
						echo "<div id='plus_profil'>";
						if ($profil->lieu_naissance)
							echo "<li><b>Lieu de naissance</b> : ".$profil->lieu_naissance."</li>";
						if ($profil->regime)
							echo "<li><b>Régime</b> : ".$profil->regime."</li>";
						if ($profil->fiche_rentree)
							echo "<li><b>Fiche de rentrée</b> : ".$profil->fiche_rentree."</li>";
						if ($profil->modification)
							echo "<li><b>Dernière modification de la fiche</b> : ".$profil->modification."</li>";
						echo "</div>";
					echo "</ul>";
				}
				?>
			</div>
			<div class="twelve columns">
				<h3>Comptabilité</h3>
				<?php
				if ($compta)
				{
				?>
					<input type='button' onclick='toggle("compta")' class='tiny secondary button' value="Voir/Cacher »" style='margin-bottom: 10px' />
					<ul id="compta">
						<li><b>Cotisant BDE</b> : <?php echo ($compta->cotisant_bde ? "Oui" : "Non"); ?></li>
						<li><b>Moyen de payement</b> : <?php echo $moyen_payement_options[$compta->moyen_payement_cotiz]; ?></li>
						<li><b>Compte à la Sogé</b> : <?php echo ($compta->compte_sg ? "Oui" : "Non"); ?></li>
						<li><b>RIB</b> : <?php echo $compta->rib; ?></li>
						<li><b>Boursier</b> : <?php echo ($compta->pallier ? "Oui" : "Non"); ?></li>
						<li><b>Intitulé du tarif</b> : <?php
						$tarifs = array(
							"" => " ",
							"bde_sg" => "BDE AVEC Sogé (150€)",
							"bde" => "BDE SANS Sogé (200€)",
						);
						echo $tarifs[$compta->tarif_intitule];
						?></li>
						<li><b>État du prélèvement</b> : <?php echo $compta->etat_prelevement; ?></li>
						<li><b>Dernière modification de la fiche</b> : <?php echo $compta->modification; ?></li>
						<?php
						if ($compta_sei)
						{
						?>
						<li><b>SEI</b>
							<ul style='margin-left: 40px;'>
								<li><b>BBQ payés :</b> <?php echo ($compta_sei->bbq_paye ? "Oui" : "Non"); ?></li>
								<li><b>Mode de payement :</b> <?php echo $moyen_payement_options[$compta_sei->mode_payement]; ?></li>
								<li><b>Prix payé :</b> <?php echo $compta_sei->prix_paye; ?> €</li>
								<li><b>Dernière modification de la fiche</b> : <?php echo $compta_sei->modification; ?></li>
							</ul>
						<?php
						}
						if ($compta_wei)
						{
						?>
						<li><b>WEI</b>
							<ul style='margin-left: 40px;'>
								<li><b>Intitulé du tarif</b> : <?php
								$tarifs = array(
									"" => " ",
									"wei_sg_non_boursier" => "WEI AVEC Sogé, non boursier (200€)",
									"wei_sg_boursier" => "WEI AVEC Sogé, boursier (130€)",
									"wei" => "BDE SANS Sogé (300€)",
								);
								echo $tarifs[$compta_wei->tarif_intitule];
								?></li>
								<li><b>Prix :</b> <?php echo $compta_wei->prix; ?> €</li>
								<li><b>Dernière modification de la fiche</b> : <?php echo $compta_wei->modification; ?></li>
							</ul>
						</li>
						<?php
						}
						?>
					</ul>
				<?php
				}
				?>
			</div>
			<div  class="twelve columns">
				<h3>SEI</h3>
				<?php
				if ($sei)
				{
				?>
					<input type='button' onclick='toggle("sei")' class='tiny secondary button' value="Voir/Cacher »" style='margin-bottom: 10px'/>
					<ul id="sei">
						<li><b>BBQ Samedi</b> : <?php echo ($sei->bbq_sam ? "Oui" : "Non"); ?></li>
						<li><b>BBQ Dimanche</b> : <?php echo ($sei->bbq_dim ? "Oui" : "Non"); ?></li>
						<li><b>BBQ Lundi</b> : <?php echo ($sei->bbq_lun ? "Oui" : "Non"); ?></li>
						<li><b>BBQ Mardi</b> : <?php echo ($sei->bbq_mar ? "Oui" : "Non"); ?></li>
						<li><b>BBQ Mercredi</b> : <?php echo ($sei->bbq_mer ? "Oui" : "Non"); ?></li>
						<li><b>BBQ Jeudi</b> : <?php echo ($sei->bbq_jeu ? "Oui" : "Non"); ?></li>
						<li><b>Dernière modification de la fiche</b> : <?php echo $sei->modification; ?></li>
					</ul>
				<?php
				}
				?>
			</div>
			<div class="twelve columns">
				<h3>WEI</h3>
				<?php
				if ($wei)
				{
				?>
					<input type='button' onclick='toggle("wei")' class='tiny secondary button' value="Voir/Cacher »" style='margin-bottom: 10px' />
					<ul id="wei">
						<li><b>Participe au WEI</b> : <?php echo ($wei->wei ? "Oui" : "Non"); ?></li>
						<li><b>Clef du bungalow</b> : <?php echo $wei->clef; ?></li>
						<li><b>État de la réservation</b> : 
							<?php
							if ($wei->etat_reservation == 0)
								echo "Non inscrit";
							elseif ($wei->etat_reservation == 1)
								echo "Annulé";
							elseif ($wei->etat_reservation == 2)
								echo "Inscrit";
							elseif ($wei->etat_reservation == 3)
								echo "Payement effectué";
							?>
						</li>
						<li><b>Bungalow</b> : 
						<?php
						if ($wei_bungalow)
							echo anchor("/backend/wei/bungalow/voir/".$wei_bungalow->id, $wei_bungalow->nom);
						?></li>
						<li><b>Équipe</b> : 
						<?php 
						if ($wei_equipe)
							echo anchor("/backend/wei/equipe/voir/".$wei_equipe->id, $wei_equipe->nom);
						?></li>
						<?php
						if (!$wei->mdp)
							echo anchor("backend/wei/generer_pass/".$adherent->id, "Générer un mot de pass", array("class" => 'secondary button'));
						else 
							echo "<li><b>Mot de passe</b> : ".$wei->mdp."</li>";
						?>
						<li><b>Dernière modification de la fiche</b> : <?php echo $wei->modification; ?></li>
					</ul>
				<?php
				}
				?>
			</div>
		</div>
		<script>
			$('#plus_adherent').hide();
			$('#plus_profil').hide();
			$('#compta').hide()
			$('#wei').hide()
			$('#sei').hide()
		</script>
	<?php
	}
	?>
</div>