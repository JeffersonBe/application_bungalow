<!-- TODO Lister personnes qui n'ont pas pas donné de caution, état de réservation  -->
<!-- TODO Chercher clef, lister tous les participants -->
<!-- TODO Page Bungalows -->
<!-- TODO Gestion équipes -->
<!-- TODO Envoi du mail avec mdp aléatoire personnel : une personne ou toutes -->
<div id="main" class="row">
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
					<td class="three columns"><?php echo "(".$bungalow->places_prises_bungalow()."/".$bungalow->capacite.") ".$bungalow->nom; ?></td>
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