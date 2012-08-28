<!-- DISI => Photo de profil et autocomplétion -->
<!-- Essayer avec nom -->
<?php echo js('showtime'); ?>
<div id="main" class="row">
	<?php
	if (!isset($modifier) || $modifier)
	{
	?>
		<div class="twelve columns">
			<?php
			if (isset($modifier))
				echo anchor("backend/adherent/voir/".$adherent->id, "Revenir sur la fiche", array("class" => "left button"))."<br /><br /><br />";
			?>
			<div class="six columns">
				<h3>Adhérent</h3>
				<ul>
					<li><b>Nom</b> : </li>
					<li><b>Prénom</b> : </li>
					<li><b>École</b> : </li>
					<li><b>Sexe</b> : </li>
					<li><b>Promotion</b> : </li>
				</ul>
			</div>
			<div class="six columns float" id="photo_adherent" style='float: right;'></div>
			<div class="six columns">
				<h3>Profil</h3>
				<input type='button' onclick='toggle("profil")' class='tiny secondary button' value="Voir/Cacher »" style='margin-bottom: 10px' />
				<?php
				echo "<ul id='profil'>";
					echo "<li><b>Login DISI</b> : </li>";
					echo "<li><b>Adresse e-mail</b> : </li>";
					echo "<li><b>Date de naissance</b> : </li>";
					echo "<li><b>Téléphone portable</b> : </li>";
					echo "<li><b>Téléphone fixe</b> : </li>";
					echo "<li><b>Adresse</b> : </li>";
					echo "<li><b>Lieu de naissance</b> : </li>";
					echo "<li><b>Régime</b> : </li>";
					echo "<li><b>Fiche de rentrée</b> : </li>";
				echo "</ul>";
				?>
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
	?>
</div>