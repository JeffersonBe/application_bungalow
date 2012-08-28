<?php echo js('showtime'); ?>
<div id="main" class="row">
	<div class="twelve columns">
		<div class="six columns">
			<h3>Adhérent</h3>
			<input type='button' id='voir_plus_adherent' onclick='reveal("plus_adherent", "voir_plus_adherent")' class='tiny secondary button' value="Plus d'informations »" style='margin-bottom: 10px' />
			<ul>
				<li><b>Nom</b> : <?php echo $adherent->nom; ?></li>
				<li><b>Prénom</b> : <?php echo $adherent->prenom; ?></li>
				<li><b>École</b> : <?php echo $adherent->ecole; ?></li>
				<li><b>Sexe</b> : <?php echo $adherent->sexe; ?></li>
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
						echo "<li><b>Date de naissance</b> : ".$profil->date_naissance."</li>";
					if ($profil->portable)
						echo "<li><b>Téléphone portable</b> : ".$profil->portable."</li>";
					if ($profil->fixe)
						echo "<li><b>Téléphone fixe</b> : ".$profil->fixe."</li>";
					if ($profil->adresse)
						echo "<li><b>Adresse</b> : ".$profil->adresse."</li>";
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
			<input type='button' onclick='toggle("compta")' class='tiny secondary button' value="Voir/Cacher" style='margin-bottom: 10px' />
			<ul id="compta">
				<li><b>Cotisant BDE</b> : Doe</li>
				<li><b>Moyen de payement</b> : John</li>
				<li><b>Intérêt pour la Sogé </b> : John</li>
				<li><b>Compte à la Sogé</b> : John</li>
				<li><b>RIB</b> : John</li>
				<li><b>Prélèvement automatique </b> : John</li>
				<li><b>Boursier</b> : John</li>
				<li><b>Intitulé du tarif</b> : John</li>
				<li><b>État du prélèvement</b> : John</li>
				<li><b>Dernière modification de la fiche</b> : 2012-05-06 12h50</li>
				<li><b>SEI</b>
					<ul style='margin-left: 40px;'>
						<li><b>BBQ payés :</b> Oui</li>
						<li><b>Prix payé :</b> 42€</li>
						<li><b>Dernière modification de la fiche</b> : 2012-05-06 12h50</li>
					</ul>
				<li><b>WEI</b>
					<ul style='margin-left: 40px;'>
						<li><b>Intitulé du tarif</b> : John</li>
						<li><b>Prix :</b> 42€</li>
						<li><b>Moyen de payement</b> : John</li>
						<li><b>Caution</b> : Non</li>
						<li><b>Dernière modification de la fiche</b> : 2012-05-06 12h50</li>
					</ul>
				</li>
			</ul>
		</div>
		<div  class="twelve columns">
			<h3>SEI</h3>
			<input type='button' onclick='toggle("sei")' class='tiny secondary button' value="Voir/Cacher" style='margin-bottom: 10px'/>
			<ul id="sei">
				<li><b>BBQ Samedi</b> : Oui</li>
				<li><b>BBQ Dimanche</b> : Oui</li>
				<li><b>BBQ Lundi</b> : Oui</li>
				<li><b>BBQ Mardi</b> : Oui</li>
				<li><b>BBQ Mercredi</b> : Oui</li>
				<li><b>BBQ Jeudi</b> : Oui</li>
				<li><b>Dernière modification de la fiche</b> : 2012-05-06 12h50</li>
			</ul>
		</div>
		<div class="twelve columns">
			<h3>WEI</h3>
			<input type='button' onclick='toggle("wei")' class='tiny secondary button' value="Voir/Cacher" style='margin-bottom: 10px' />
			<ul id="wei">
				<li><b>Intérêt pour le WEI</b> : Doe</li>
				<li><b>Participe au WEI</b> : John</li>
				<li><b>Clef du bungalow</b> : TEM</li>
				<li><b>État de la réservation</b> : Homme</li>
				<li><b>Bungalow</b> : /backend/wei/bungalow/voir/id 2012 - 2015 (mettre lien)</li>
				<li><b>Équipe</b> : /backend/wei/equipe/voir/id</li>
				<li><b>Dernière modification de la fiche</b> : 2012-05-06 12h50</li>
			</ul>
		</div>
	</div>
</div>

<script>
	$('#plus_adherent').hide();
	$('#plus_profil').hide();
	$('#compta').hide()
	$('#wei').hide()
	$('#sei').hide()
</script>