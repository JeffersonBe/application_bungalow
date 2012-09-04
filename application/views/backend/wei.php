<!-- TODO Lister personnes qui n'ont pas pas donné de caution, état de réservation  -->
<!-- TODO Chercher clef, lister tous les participants -->
<!-- TODO Page Bungalows -->
<!-- TODO Gestion équipes -->
<!-- TODO Envoi du mail avec mdp aléatoire personnel : une personne ou toutes -->
<div id="main" class="row">
	<?php echo form_open('backend/adherent/chercher'); ?>
	<fieldset>
	
	<legend>Rechercher participants</legend>
		<?php echo validation_errors(); ?> 

		<div class="six columns">
			<?php
			$input = array(
				'name' => 'clef',
				'value' => set_value('clef', ''),
				'placeholder' => 'Clef',
				'id' => 'clef',
			);
			?>
			<div class='three columns'>
				<label for="clef" class="inline"><b>Clef</b> : </label>
			</div>
			<div class='nine columns'>
				<?php echo form_input($input); ?>
			</div>
		</div>
		<div class="six columns">
			<?php
			$input = array(
				"name" => "uniquement_sans_bungalow",
				"value" => set_value('uniquement_sans_bungalow', '1'),
				"id" => "uniquement_sans_bungalow",
			);
			?>
			<div class="seven columns"><label for="uniquement_sans_bungalow"><b>Uniquement sans bungalow</b> :</label></div>
			<div class="one column left"><input type="checkbox" name="uniquement_sans_bungalow" id="uniquement_sans_bungalow" value="1" <?php echo set_checkbox('uniquement_sans_bungalow', '1'); ?> /></div>
			<div class="four columns"></div>
		</div>
		<div class="six columns">
			<?php
			$input = array(
				"name" => "uniquement_sans_caution",
				"value" => set_value('uniquement_sans_caution', '1'),
				"id" => "uniquement_sans_caution",
			);
			?>
			<div class="seven columns"><label for="uniquement_sans_caution"><b>Uniquement sans caution</b> :</label></div>
			<div class="one column left"><input type="checkbox" name="uniquement_sans_caution" id="uniquement_sans_caution" value="1" <?php echo set_checkbox('uniquement_sans_caution', '1'); ?> /></div>
			<div class="four columns"></div>
		</div>
		<div class='twelve columns'>
			<div class='five columns'></div>
			<div class="two columns">
				<?php
				$input = array(
					'name' => 'submit',
					'value' => 'Chercher',
					'class' => 'twelve small button columns',
					'style' => 'margin-bottom: 10px;',
				);

				echo form_submit($input);
				echo form_close();
				?>
			</div>
			<div class='five columns'></div>
		</div>
	</fieldset>
	<div class='twelve columns'>
		<div class="three columns"></div>
		<?php echo anchor("backend/equipe/nouveau", "Nouvelle équipe", array('class'=> "three large button columns")); ?>
		<?php echo anchor("backend/bungalow/nouveau", "Nouveau bungalow", array('class'=> "three large button columns")); ?>
		<div class="three columns"></div>
	</div>
	<div class='twelve columns'>
		<h3>Equipes</h3>
		<table class="ten columns centered">
			<?php
			if ($equipes)
			{
				foreach($equipes as $equipe)
				{
				?>
					<tr>
						<td class="six columns"><?php echo $equipe->nom." (".count($equipe->lister_membres(0)).")"; ?></td>
						<td class="two columns">
							<?php echo anchor("backend/equipe/voir/".$equipe->id, "Consulter", array('class' => "tiny regular button")); ?>
						</td>
						<td class="two columns">
							<?php echo anchor("backend/equipe/modifier/".$equipe->id, "Modifier", array('class' => "tiny secondary button")); ?>
						</td>
						<td class="two columns">
							<?php echo anchor("backend/equipe/supprimer/".$equipe->id, "Supprimer",
								array(
									'class' => "tiny alert button",
								)
							); ?>
						</td>
					</tr>
				<?php
				}
			}
			?>
		</table>
	</div>
	<div class='twelve columns'>
		<h3>Bungalows</h3>
		<table class="ten columns centered">
			<?php
			foreach($bungalows as $bungalow)
			{
			?>
				<tr>
					<td class="one columns"><?php echo $bungalow->numero; ?></td>
					<td class="three columns">
							<?php
								$places_prises = $bungalow->places_prises_bungalow();
								if ($places_prises == $bungalow->capacite)
									echo "<b>(".$places_prises."/".$bungalow->capacite.") ".$bungalow->nom."</b>";
								else
									echo "(".$places_prises."/".$bungalow->capacite.") ".$bungalow->nom;
							?>
					</td>
					<td class="two columns"><?php echo $bungalow->equipe_id ? $bungalow->_equipe->nom : '<span class="alert label">Sans équipe</span>'; ?></td>
					<td class="two columns">
						<?php echo anchor("backend/equipe/voir/".$bungalow->id, "Consulter", array('class' => "tiny regular button")); ?>
					</td>
					<td class="two columns">
						<?php echo anchor("backend/equipe/modifier/".$bungalow->id, "Modifier", array('class' => "tiny secondary button")); ?>
					</td>
					<td class="two columns">
						<?php echo anchor("backend/equipe/supprimer/".$bungalow->id, "Supprimer",
							array(
								'class' => "tiny alert button",
							)
						); ?>
					</td>
				</tr>
			<?php
			}
			?>
		</table>
	</div>
</div>