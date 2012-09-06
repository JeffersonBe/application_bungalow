<div id="main" class="row">
	<?php echo form_open('backend/wei/chercher'); ?>
	<fieldset>
	
	<legend>Rechercher participants</legend>
		<?php echo validation_errors(); ?> 

		<div class="six columns">
			<?php
			$input = array(
				'name' => 'numero',
				'value' => set_value('numero', ''),
				'placeholder' => 'Numéro',
				'id' => 'numero',
			);
			?>
			<div class='three columns'>
				<label for="numero" class="inline"><b>Numéro</b> : </label>
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
		<?php echo anchor("backend/wei/equipe/nouveau", "Nouvelle équipe", array('class'=> "three button columns")); ?>
		<?php echo anchor("backend/wei/bungalow/nouveau", "Nouveau bungalow", array('class'=> "three button columns")); ?>
		<div class="three columns"></div>
	</div>
	<div class='twelve columns' style='margin-bottom: 20px;'>
		<h3>Equipes</h3>
		<table class="ten columns centered">
			<?php
			if ($equipes)
			{
				foreach($equipes as $equipe)
				{
				?>
					<tr>
						<?php
						if (!$equipe->hexa)
							echo '<td class="six columns">'.$equipe->nom.' ('.$equipe->compter_membres().')</td>';
						else
							echo '<td class="six columns" style="color: #'.$equipe->hexa.';">'.$equipe->nom.' ('.$equipe->compter_membres().')</td>';
						?>
						<td class="two columns">
							<?php echo anchor("backend/wei/equipe/voir/".$equipe->id, "Consulter", array('class' => "tiny regular button", 'target' => '_blank')); ?>
						</td>
						<td class="two columns">
							<?php echo anchor("backend/wei/equipe/modifier/".$equipe->id, "Modifier", array('class' => "tiny secondary button")); ?>
						</td>
						<td class="two columns">
							<?php
							if ($equipe->id != 1)
							{
								echo anchor("backend/wei/equipe/supprimer/".$equipe->id, "Supprimer",
									array(
										'class' => "tiny alert button",
									)
								);
							}
							?>
						</td>
					</tr>
				<?php
				}
			}
			?>
		</table>
	</div>
	
	<dl class="tabs">
		<dd class="active"><a href="#1A">Bungalows 1A</a></dd>
		<dd><a href="#staff">Bungalows Staff</a></dd>
	</dl>

	<ul class="tabs-content">
		<li class="active" id="1ATab">

			<div class='twelve columns'>
				<table class="ten columns centered" style='margin-top: 10px;'>
					<?php
					foreach($bungalows as $bungalow)
					{
						if ($bungalow->equipe_id != 1)
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
								<td class="two columns">
									<?php
										echo $bungalow->equipe_id ? $bungalow->_equipe->nom : '<span class="alert label">Sans équipe</span>'; ?></td>
								<td class="two columns">
									<?php echo anchor("backend/wei/bungalow/voir/".$bungalow->id, "Consulter", array('class' => "tiny regular button", 'target' => '_blank')); ?>
								</td>
								<td class="two columns">
									<?php echo anchor("backend/wei/bungalow/modifier/".$bungalow->id, "Modifier", array('class' => "tiny secondary button")); ?>
								</td>
								<td class="two columns">
									<?php echo anchor("backend/wei/bungalow/supprimer/".$bungalow->id, "Supprimer",
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

		</li>
		<li id="staffTab">
	
			<div class='twelve columns'>
				<table class="ten columns centered" style='margin-top: 10px;'>
					<?php
					foreach($bungalows as $bungalow)
					{
						if ($bungalow->equipe_id == 1)
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
								<td class="two columns">
									<?php
										echo $bungalow->equipe_id ? $bungalow->_equipe->nom : '<span class="alert label">Sans équipe</span>'; ?></td>
								<td class="two columns">
									<?php echo anchor("backend/wei/bungalow/voir/".$bungalow->id, "Consulter", array('class' => "tiny regular button", 'target' => '_blank')); ?>
								</td>
								<td class="two columns">
									<?php echo anchor("backend/wei/bungalow/modifier/".$bungalow->id, "Modifier", array('class' => "tiny secondary button")); ?>
								</td>
								<td class="two columns">
									<?php echo anchor("backend/wei/bungalow/supprimer/".$bungalow->id, "Supprimer",
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
		</li>
	</ul>
</div>