<div id="main" class="row">
	<?php
	if (!isset($modifier) || $modifier)
	{
		if (isset($modifier))
			echo form_open('backend/wei/bungalow/modifier/'.$bungalow->id);
		else
			echo form_open('backend/wei/bungalow/nouveau');
	?>
		<div class="twelve columns">
			<?php
			if (isset($modifier))
				echo anchor("backend/wei/bungalow/voir/".$bungalow->id, "Revenir sur la page du bungalow", array("class" => "left button"))."<br /><br /><br />";
			?>
			<?php echo validation_errors(); ?> 
			<div class="six columns">
				<div class="row">
					<?php
					$input = array(
						"name" => "numero",
						"value" => set_value('numero', (isset($bungalow->numero) ? $bungalow->numero : '')),
						"id" => "numero",
					);
					?>
					<div class="four columns"><label for="numero" class="inline"><b>Numéro *</b> :</label></div>
					<div class="eight columns"><? echo form_input($input); ?></div>
				</div>
				<div class="row">
					<?php
					$input = array(
						"name" => "nom",
						"value" => set_value('nom', (isset($bungalow->nom) ? $bungalow->nom : '')),
						"id" => "nom",
					);
					?>
					<div class="four columns"><label for="nom" class="inline"><b>Nom </b> :</label></div>
					<div class="eight columns"><? echo form_input($input); ?></div>
				</div>
				<div class="row">
					<?php
					$input = array(
						"name" => "capacite",
						"value" => set_value('capacite', (isset($bungalow->capacite) ? $bungalow->capacite : '')),
						"id" => "capacite",
					);
					?>
					<div class="four columns"><label for="capacite" class="inline"><b>Capacité </b> :</label></div>
					<div class="eight columns"><? echo form_input($input); ?></div>
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
					<div class="three columns"><? echo form_dropdown('equipe', $options, set_value('equipe', (isset($bungalow->equipe_id) ? $bungalow->equipe_id : ''))); ?></div>
					<div class="six columns"></div>
				</div>
				<div class="twelve columns">
					* : Champ obligatoire
					<br /><br />
					<input type="submit" class="button" />
				</div>
			</div>

		</div>
	<?php
	}
	echo form_close()
	?>
</div>