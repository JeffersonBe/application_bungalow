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
			echo form_open('backend/adherent/nouveau/'.$adherent_id);
	?>
		<div class="twelve columns">
			<?php
			if (isset($modifier))
				echo anchor("backend/adherent/voir/".$adherent->id, "Revenir sur la fiche", array("class" => "left button"))."<br /><br /><br />";
			?>
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
					<div class="four columns"><label for="nom" class="inline"><b>Nom</b> :</label></div>
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
					<div class="four columns"><label for="prenom" class="inline"><b>Prénom</b> :</label></div>
					<div class="eight columns"><? echo form_input($input); ?></div>
				</div>
				<div class="row">
					<?php
					$options = array(
						"tem" => "TEM",
						"tsp" => "TSP",
					);
					?>
					<div class="four columns"><label for="ecole" class="inline"><b>École</b> :</label></div>
					<div class="eight columns"><? echo form_dropdown('ecole', $options, set_value('ecole', (isset($adherent->ecole) ? $adherent->ecole : 'tem')), "id='ecole'"); ?></div>
				</div>
				<div class="row">
					<?php
					$options = array(
						"f" => "Femme",
						"m" => "Homme",
					);
					?>
					<div class="four columns"><label for="sexe" class="inline"><b>Sexe</b> :</label></div>
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
					<div class="four columns"><label for="promotion" class="inline"><b>Promotion</b> :</label></div>
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
							"value" => set_value('date_naissance', (isset($profil->date_naissance) ? $profil->date_naissance : '')),
							"id" => "date_naissance",
						);
						?>
						<div class="six columns"><label for="date_naissance" class="inline"><b>Date de naissance (j/m/a)</b> :</label></div>
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
							"value" => set_value('adresse', (isset($profil->adresse) ? $profil->adresse : '')),
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
				<ul id="compta">
					<li><b>Cotisant BDE</b> : </li>
					<li><b>Moyen de payement</b> : </li>
					<li><b>Intérêt pour la Sogé </b> : </li>
					<li><b>Compte à la Sogé</b> : </li>
					<li><b>RIB</b> : </li>
					<li><b>Prélèvement automatique </b> : </li>
					<li><b>Boursier</b> : </li>
					<li><b>Intitulé du tarif</b> : </li>
					<li><b>État du prélèvement</b> : </li>
					<li><b>SEI</b>
						<ul style='margin-left: 40px;'>
							<li><b>BBQ payés :</b> </li>
							<li><b>Prix payé :</b> </li>
						</ul>
					<li><b>WEI</b>
						<ul style='margin-left: 40px;'>
							<li><b>Intitulé du tarif</b> : </li>
							<li><b>Prix :</b> </li>
							<li><b>Moyen de payement</b> : </li>
							<li><b>Caution</b> : </li>
						</ul>
					</li>
				</ul>
			</div>
			<div  class="twelve columns">
				<h3>SEI</h3>
				<input type='button' onclick='toggle("sei")' class='tiny secondary button' value="Voir/Cacher »" style='margin-bottom: 10px'/>
				<ul id="sei">
					<li><b>BBQ Samedi</b> : </li>
					<li><b>BBQ Dimanche</b> : </li>
					<li><b>BBQ Lundi</b> : </li>
					<li><b>BBQ Mardi</b> : </li>
					<li><b>BBQ Mercredi</b> : </li>
					<li><b>BBQ Jeudi</b> : </li>
				</ul>
			</div>
			<div class="twelve columns">
				<h3>WEI</h3>
				<input type='button' onclick='toggle("wei")' class='tiny secondary button' value="Voir/Cacher »" style='margin-bottom: 10px' />
				<ul id="wei">
					<li><b>Intérêt pour le WEI</b> : </li>
					<li><b>Participe au WEI</b> : </li>
					<li><b>Clef du bungalow</b> : </li>
					<li><b>État de la réservation</b> : </li>
					<li><b>Bungalow</b> : </li>
					<li><b>Équipe</b> : </li>
				</ul>
			</div>
		</div>
		<script>
			$('#profil').hide();
			$('#compta').hide()
			$('#wei').hide()
			$('#sei').hide()
		</script>
	<?php
	}
	echo form_close()
	?>
</div>