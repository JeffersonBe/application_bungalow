<div id="main" class="row">
	<?php
	if (!isset($modifier) || $modifier)
	{
		if (isset($modifier))
			echo form_open('backend/wei/equipe/modifier/'.$equipe->id);
		else
			echo form_open('backend/wei/equipe/nouveau');
	?>
		<div class="twelve columns">
			<?php
			if (isset($modifier))
				echo anchor("backend/wei/equipe/voir/".$equipe->id, "Revenir sur la page de l'équipe", array("class" => "left button"))."<br /><br /><br />";
			?>
			<?php echo validation_errors(); ?> 
			<div class="six columns">
				<h3>Adhérent</h3>
				<div class="row">
					<?php
					$input = array(
						"name" => "nom",
						"value" => set_value('nom', (isset($equipe->nom) ? $equipe->nom : '')),
						"id" => "nom",
					);
					?>
					<div class="four columns"><label for="nom" class="inline"><b>Nom *</b> :</label></div>
					<div class="eight columns"><? echo form_input($input); ?></div>
				</div>
				<div class="row">
					<?php
					$input = array(
						"name" => "hexa",
						"value" => set_value('hexa', (isset($equipe->hexa) ? $equipe->hexa : '')),
						"id" => "hexa",
					);
					?>
					<div class="four columns"><label for="hexa" class="inline"><b>Couleur (code RGB en hexadécimal)</b> :</label></div>
					<div class="eight columns"><? echo form_input($input); ?></div>
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