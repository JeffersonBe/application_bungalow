<!-- DISI => Photo de profil et autocomplétion -->
<!-- Essayer avec nom -->
<?php echo js('showtime'); ?>


<?php
// Le LDAP n'a pas l'air de fonctionner
// $ldap_c = ldap_connect('annuaire.it-sudparis.eu', 636);
// var_dump($ldap_c);
// $ldap_b = ldap_bind($ldap_c, 'uid=,ou=people,o=it-sudparis,c=eu', '');
// var_dump($ldap_b);
?>

<div id="main" class="row">
	<?php
	if (!isset($modifier) || $modifier)
	{
		if (isset($modifier))
			echo form_open('backend/adherent/modifier/'.$adherent->id);
		else
			echo form_open('backend/adherent/nouveau');
	?>
		<div class="twelve columns">
			<?php
			if (isset($modifier))
				echo anchor("backend/adherent/voir/".$adherent->id, "Revenir sur la fiche", array("class" => "left button"))."<br /><br /><br />";
			?>
			<?php echo validation_errors(); ?> 
			<div class="six columns">
				<h3>Adhérent</h3>
				<div class="row">
					<?php
					$input = array(
						"name" => "nom",
						"value" => set_value('nom', (isset($adherent->nom) ? $adherent->nom : '')),
						"id" => "nom",
					);
					?>
					<div class="four columns"><label for="nom" class="inline"><b>Nom *</b> :</label></div>
					<div class="eight columns"><? echo form_input($input); ?></div>
				</div>
				<div class="row">
					<?php
					$input = array(
						"name" => "prenom",
						"value" => set_value('prenom', (isset($adherent->prenom) ? $adherent->prenom : '')),
						"id" => "prenom",
					);
					?>
					<div class="four columns"><label for="prenom" class="inline"><b>Prénom *</b> :</label></div>
					<div class="eight columns"><? echo form_input($input); ?></div>
				</div>
				<div class="row">
					<?php
					$options = array(
						"tem" => "TEM",
						"tsp" => "TSP",
					);
					?>
					<div class="four columns"><label for="ecole" class="inline"><b>École *</b> :</label></div>
					<div class="eight columns"><? echo form_dropdown('ecole', $options, set_value('ecole', (isset($adherent->ecole) ? $adherent->ecole : 'tem')), "id='ecole'"); ?></div>
				</div>
				<div class="row">
					<?php
					$options = array(
						"f" => "Femme",
						"m" => "Homme",
					);
					?>
					<div class="four columns"><label for="sexe" class="inline"><b>Sexe *</b> :</label></div>
					<div class="eight columns"><? echo form_dropdown('sexe', $options, set_value('sexe', (isset($adherent->sexe) ? $adherent->sexe : 'f')), "id='sexe'"); ?></div>
				</div>
				<div class="row">
					<?php
					$options = array(
						"2015" => "2012 - 2015",
						"2014" => "2011 - 2014",
						"2010" => "2010 - 2013",
					);
					?>
					<div class="four columns"><label for="promotion" class="inline"><b>Promotion *</b> :</label></div>
					<div class="eight columns"><? echo form_dropdown('promotion', $options, set_value('promotion', (isset($adherent->promotion) ? $adherent->promotion : '2015')), "id='promotion'"); ?></div>
				</div>
			</div>
			<div class="six columns float" id="photo_adherent" style='float: right;'></div>
			<div class="six columns">
				<h3>Profil</h3>
				<input type='button' onclick='toggle("profil")' class='tiny secondary button' value="Voir/Cacher »" style='margin-bottom: 10px' />
				<div id="profil">
					<div class="row">
						<?php
						$input = array(
							"name" => "disi",
							"value" => set_value('disi', (isset($profil->disi) ? $profil->disi : '')),
							"id" => "disi",
							"onBlur" => "charge_photo(this.value)",
						);
						?>
						<div class="six columns"><label for="disi" class="inline"><b>Login DISI</b> :</label></div>
						<div class="six columns"><? echo form_input($input); ?></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "email",
							"value" => set_value('email', (isset($profil->email) ? $profil->email : '')),
							"id" => "email",
						);
						?>
						<div class="six columns"><label for="email" class="inline"><b>Adresse e-mail</b> :</label></div>
						<div class="six columns"><? echo form_input($input); ?></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "date_naissance",
							"value" => set_value('date_naissance', (isset($profil->date_naissance) ? formater_date_ecran($profil->date_naissance) : '')),
							"id" => "date_naissance",
						);
						?>
						<div class="six columns"><label for="date_naissance" class="inline"><b>Date de naissance (jj/mm/aaaa)</b> :</label></div>
						<div class="six columns"><? echo form_input($input); ?></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "portable",
							"value" => set_value('portable', (isset($profil->portable) ? $profil->portable : '')),
							"id" => "portable",
						);
						?>
						<div class="six columns"><label for="portable" class="inline"><b>Téléphone portable</b> :</label></div>
						<div class="six columns"><? echo form_input($input); ?></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "fixe",
							"value" => set_value('fixe', (isset($profil->fixe) ? $profil->fixe : '')),
							"id" => "fixe",
						);
						?>
						<div class="six columns"><label for="fixe" class="inline"><b>Téléphone fixe</b> :</label></div>
						<div class="six columns"><? echo form_input($input); ?></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "adresse",
							"value" => set_value('adresse', (isset($profil->adresse) ? br2nl($profil->adresse) : '')),
							"id" => "adresse",
							"rows" => 3,
						);
						?>
						<div class="six columns"><label for="adresse" class="inline"><b>Adresse</b> :</label></div>
						<div class="six columns"><? echo form_textarea($input); ?></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "lieu_naissance",
							"value" => set_value('lieu_naissance', (isset($profil->lieu_naissance) ? $profil->lieu_naissance : '')),
							"id" => "lieu_naissance",
						);
						?>
						<div class="six columns"><label for="lieu_naissance" class="inline"><b>Lieu de naissance</b> :</label></div>
						<div class="six columns"><? echo form_input($input); ?></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "regime",
							"value" => set_value('regime', (isset($profil->regime) ? $profil->regime : '')),
							"id" => "regime",
							"placeholder" => "Halal, Casher, Végétarien, ..."
						);
						?>
						<div class="six columns"><label for="regime" class="inline"><b>Régime</b> :</label></div>
						<div class="six columns"><? echo form_input($input); ?></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "fiche_rentree",
							"value" => set_value('fiche_rentree', (isset($profil->fiche_rentree) ? $profil->fiche_rentree : '')),
							"id" => "fiche_rentree",
						);
						?>
						<div class="six columns"><label for="fiche_rentree" class="inline"><b>Fiche de rentrée</b> :</label></div>
						<div class="six columns"><? echo form_input($input); ?></div>
					</div>
				</div>
			</div>
			<div class="twelve columns">
				<h3>Comptabilité</h3>
				<input type='button' onclick='toggle("compta")' class='tiny secondary button' value="Voir/Cacher »" style='margin-bottom: 10px' />
				<div id="compta">
					<div class="row">
						<?php
						$input = array(
							"name" => "cotisant_bde",
							"value" => set_value('cotisant_bde', (isset($compta->cotisant_bde) ? $compta->cotisant_bde : '1')),
							"id" => "cotisant_bde",
						);
						?>
						<div class="three columns"><label for="cotisant_bde"><b>Cotisant BDE</b> :</label></div>
						<!-- TODO: test -->
						<div class="three columns left"><input type="checkbox" name="cotisant_bde" id="cotisant_bde" value="1" <?php echo set_checkbox('cotisant_bde', '1', (isset($compta) && $compta && $compta->cotisant_bde)); ?> /></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$options = array(
							"" => " ",
							"prelevement" => "Prélèvement",
							"cheque" => "Chèque",
							"liquide" => "Liquide",
						);
						?>
						<div class="three columns"><label for="moyen_payement_cotiz" class="inline"><b>Moyen de payement de la cotisation</b> :</label></div>
						<div class="three columns"><? echo form_dropdown('moyen_payement_cotiz', $options, set_value('moyen_payement_cotiz', (isset($compta->moyen_payement_cotiz) ? $compta->moyen_payement_cotiz : '')), "id='moyen_payement_cotiz'"); ?></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "compte_sg",
							"value" => set_value('compte_sg', (isset($compta->compte_sg) ? $compta->compte_sg : '1')),
							"id" => "compte_sg",
						);
						?>
						<div class="three columns"><label for="compte_sg"><b>Compte à la Sogé</b> :</label></div>
						<!-- TODO: test -->
						<div class="three columns left"><input type="checkbox" name="compte_sg" id="compte_sg" value="1" <?php echo set_checkbox('compte_sg', '1', (isset($compta) && $compta && $compta->compte_sg)); ?> /></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "rib",
							"value" => set_value('rib', (isset($compta->rib) ? $compta->rib : '')),
							"id" => "rib",
						);
						?>
						<div class="three columns"><label for="rib" class="inline"><b>RIB</b> :</label></div>
						<div class="three columns"><? echo form_input($input); ?></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "boursier",
							"value" => set_value('boursier', (isset($compta->pallier) ? $compta->pallier : '1')),
							"id" => "boursier",
						);
						?>
						<div class="three columns"><label for="boursier"><b>Boursier</b> :</label></div>
						<!-- TODO: test -->
						<div class="three columns left"><input type="checkbox" name="boursier" id="boursier" value="1" <?php echo set_checkbox('boursier', '1', (isset($compta) && $compta && $compta->pallier)); ?> /></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$options = array(
							"" => " ",
							"bde_sg" => "BDE AVEC Sogé (150€)",
							"bde" => "BDE SANS Sogé (200€)",
						);
						?>
						<div class="three columns"><label for="intitule_tarif_cotiz" class="inline"><b>Intitulé du tarif</b> :</label></div>
						<div class="three columns"><? echo form_dropdown('intitule_tarif_cotiz', $options, set_value('intitule_tarif_cotiz', (isset($compta->tarif_intitule) ? $compta->tarif_intitule : '')), "id='intitule_tarif_cotiz'"); ?></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "etat_prelevement_cotiz",
							"value" => set_value('etat_prelevement_cotiz', (isset($compta->etat_prelevement) ? $compta->etat_prelevement : '')),
							"id" => "etat_prelevement_cotiz",
						);
						?>
						<div class="three columns"><label for="etat_prelevement_cotiz" class="inline"><b>État du prélèvement de la cotisation</b> :</label></div>
						<div class="three columns"><? echo form_input($input); ?></div>
						<div class="six columns"></div>
					</div>
					<h4>SEI</h4>
					<div class="row">
						<?php
						$input = array(
							"name" => "bbq_paye",
							"value" => set_value('bbq_paye', (isset($compta_sei->bbq_paye) ? $compta_sei->bbq_paye : '1')),
							"id" => "bbq_paye",
						);
						?>
						<div class="three columns"><label for="bbq_paye"><b>BBQ payés</b> :</label></div>
						<!-- TODO: test -->
						<div class="three columns left"><input type="checkbox" name="bbq_paye" id="bbq_paye" value="1" <?php echo set_checkbox('bbq_paye', '1', (isset($compta_sei) && $compta_sei && $compta_sei->bbq_paye)); ?> /></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$options = array(
							"" => " ",
							"cheque" => "Chèque",
							"liquide" => "Liquide",
						);
						?>
						<div class="three columns"><label for="moyen_payement_sei" class="inline"><b>Moyen de payement des BBQ</b> :</label></div>
						<div class="three columns"><? echo form_dropdown('moyen_payement_sei', $options, set_value('moyen_payement_sei', (isset($compta_sei->mode_payement) ? $compta_sei->mode_payement : '')), "id='moyen_payement_sei'"); ?></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "prix_paye_sei",
							"value" => set_value('prix_paye_sei', (isset($compta_sei->prix_paye) ? $compta_sei->prix_paye : '')),
							"id" => "prix_paye_sei",
						);
						?>
						<div class="three columns"><label for="prix_paye_sei" class="inline"><b>Prix payé pour les BBQ</b> :</label></div>
						<div class="three columns"><? echo form_input($input); ?></div>
						<div class="six columns"></div>
					</div>
					<h4>WEI</h4>
					<div class="row">
						<?php
						$options = array(
							"" => " ",
							"wei_sg_non_boursier" => "WEI AVEC Sogé, non boursier (200€)",
							"wei_sg_boursier" => "WEI AVEC Sogé, boursier (130€)",
							"wei" => "BDE SANS Sogé (300€)",
						);
						?>
						<div class="three columns"><label for="intitule_tarif_wei" class="inline"><b>Intitulé du tarif</b> :</label></div>
						<div class="three columns"><? echo form_dropdown('intitule_tarif_wei', $options, set_value('intitule_tarif_wei', (isset($compta_wei->tarif_intitule) ? $compta_wei->tarif_intitule : '')), "id='intitule_tarif_wei'"); ?></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "caution_wei",
							"value" => set_value('caution_wei', (isset($compta_wei->caution) ? $compta_wei->caution : '1')),
							"id" => "caution_wei",
						);
						?>
						<div class="three columns"><label for="caution_wei"><b>Caution prise</b> :</label></div>
						<!-- TODO: test -->
						<div class="three columns left"><input type="checkbox" name="caution_wei" id="caution_wei" value="1" <?php echo set_checkbox('caution_wei', '1', (isset($compta_wei) && $compta_wei && $compta_wei->caution)); ?> /></div>
						<div class="six columns"></div>
					</div>
				</div>
			</div>
			<div  class="twelve columns">
				<h3>SEI</h3>
				<input type='button' onclick='toggle("sei")' class='tiny secondary button' value="Voir/Cacher »" style='margin-bottom: 10px'/>
				<div id="sei">
					<div class="row">
						<?php
						$input = array(
							"name" => "bbq_sam",
							"value" => set_value('bbq_sam', (isset($sei->bbq_sam) ? $sei->bbq_sam : '1')),
							"id" => "bbq_sam",
						);
						?>
						<div class="three columns"><label for="bbq_sam"><b>BBQ Samedi</b> :</label></div>
						<!-- TODO: test -->
						<div class="three columns left"><input type="checkbox" name="bbq_sam" id="bbq_sam" value="1" <?php echo set_checkbox('bbq_sam', '1', (isset($sei) && $sei && $sei->bbq_sam)); ?> /></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "bbq_dim",
							"value" => set_value('bbq_dim', (isset($sei->bbq_dim) ? $sei->bbq_dim : '1')),
							"id" => "bbq_dim",
						);
						?>
						<div class="three columns"><label for="bbq_dim"><b>BBQ Dimanche</b> :</label></div>
						<!-- TODO: test -->
						<div class="three columns left"><input type="checkbox" name="bbq_dim" id="bbq_dim" value="1" <?php echo set_checkbox('bbq_dim', '1', (isset($sei) && $sei && $sei->bbq_dim)); ?> /></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "bbq_lun",
							"value" => set_value('bbq_lun', (isset($sei->bbq_lun) ? $sei->bbq_lun : '1')),
							"id" => "bbq_lun",
						);
						?>
						<div class="three columns"><label for="bbq_lun"><b>BBQ Lundi</b> :</label></div>
						<!-- TODO: test -->
						<div class="three columns left"><input type="checkbox" name="bbq_lun" id="bbq_lun" value="1" <?php echo set_checkbox('bbq_lun', '1', (isset($sei) && $sei && $sei->bbq_lun)); ?> /></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "bbq_mar",
							"value" => set_value('bbq_mar', (isset($sei->bbq_mar) ? $sei->bbq_mar : '1')),
							"id" => "bbq_mar",
						);
						?>
						<div class="three columns"><label for="bbq_mar"><b>BBQ Mardi</b> :</label></div>
						<!-- TODO: test -->
						<div class="three columns left"><input type="checkbox" name="bbq_mar" id="bbq_mar" value="1" <?php echo set_checkbox('bbq_mar', '1', (isset($sei) && $sei && $sei->bbq_mar)); ?> /></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "bbq_mer",
							"value" => set_value('bbq_mer', (isset($sei->bbq_mer) ? $sei->bbq_mer : '1')),
							"id" => "bbq_mer",
						);
						?>
						<div class="three columns"><label for="bbq_mer"><b>BBQ Mercredi</b> :</label></div>
						<!-- TODO: test -->
						<div class="three columns left"><input type="checkbox" name="bbq_mer" id="bbq_mer" value="1" <?php echo set_checkbox('bbq_mer', '1', (isset($sei) && $sei && $sei->bbq_mer)); ?> /></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "bbq_jeu",
							"value" => set_value('bbq_jeu', (isset($sei->bbq_jeu) ? $sei->bbq_jeu : '1')),
							"id" => "bbq_jeu",
						);
						?>
						<div class="three columns"><label for="bbq_jeu"><b>BBQ Jeudi</b> :</label></div>
						<!-- TODO: test -->
						<div class="three columns left"><input type="checkbox" name="bbq_jeu" id="bbq_jeu" value="1" <?php echo set_checkbox('bbq_jeu', '1', (isset($sei) && $sei && $sei->bbq_jeu)); ?> /></div>
						<div class="six columns"></div>
					</div>
				</div>
			</div>
			<div class="twelve columns">
				<h3>WEI</h3>
				<input type='button' onclick='toggle("wei")' class='tiny secondary button' value="Voir/Cacher »" style='margin-bottom: 10px' />
				<div id="wei">
					<div class="row">
						<?php
						$input = array(
							"name" => "wei_go",
							"value" => set_value('wei_go', (isset($sei->wei) ? $sei->wei : '1')),
							"id" => "wei_go",
						);
						?>
						<div class="three columns"><label for="wei_go"><b>WEI</b> :</label></div>
						<!-- TODO: test -->
						<div class="three columns left"><input type="checkbox" name="wei_go" id="wei_go" value="1" <?php echo set_checkbox('wei_go', '1', (isset($wei) && $wei && $wei->wei)); ?> /></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$input = array(
							"name" => "clef",
							"value" => set_value('clef', (isset($wei->clef) ? $wei->clef : '')),
							"id" => "clef",
						);
						?>
						<div class="three columns"><label for="clef" class="inline"><b>Clé du bungalow</b> :</label></div>
						<div class="three columns"><? echo form_input($input); ?></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$options = array(
							"0" => "Non inscrit",
							"1" => "Annulé",
							"2" => "Inscrit",
							"3" => "Payement effectué",
						);
						?>
						<div class="three columns"><label for="etat_reservation" class="inline"><b>État de la réservation</b> :</label></div>
						<div class="three columns"><? echo form_dropdown('etat_reservation', $options, set_value('etat_reservation', (isset($wei->etat_reservation) ? $wei->etat_reservation : '0')), "id='etat_reservation'"); ?></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$options = array('' => 'Aucun');

						if ($liste_bungalow)
						{
							foreach($liste_bungalow as $bungalow)
								$options[$bungalow->id] = $bungalow->numero." ".$bungalow->nom;
						}
						?>
						<div class="three columns"><label for="bungalow" class="inline"><b>Bungalow</b> :</label></div>
						<div class="three columns"><? echo form_dropdown('bungalow', $options, set_value('bungalow', (isset($wei->bungalow_id) ? $wei->bungalow_id : ''))); ?></div>
						<div class="six columns"></div>
					</div>
					<div class="row">
						<?php
						$options = array('' => 'Aucune');

						if ($liste_equipes)
						{
							foreach($liste_equipes as $equipe)
								$options[$equipe->id] = $equipe->nom;
						}
						?>
						<div class="three columns"><label for="equipe" class="inline"><b>Équipe</b> :</label></div>
						<div class="three columns"><? echo form_dropdown('equipe', $options, set_value('equipe', (isset($wei->equipe_id) ? $wei->equipe_id : ''))); ?></div>
						<div class="six columns"></div>
					</div>
				</div>
				<div class="twelve columns">
					* : Champ obligatoire
					<br /><br />
					<input type="submit" class="button" />
				</div>
			</div>

		</div>

		<script>
			<?php
			if (isset($modifier) && $modifier)
			{
				echo "$('#profil').hide();";
				echo "$('#compta').hide();";
				echo "$('#wei').hide();";
				echo "$('#sei').hide();";
			}
			if ($profil->disi)
			{
				echo "charge_photo('".$profil->disi."');";
			}
			?>
		</script>
	<?php
	}
	echo form_close()
	?>
</div>