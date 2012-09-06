<div id="main" class="row">
	<?php
	if (isset($titre_recherche))
		echo "<h1 class='ten subheader mobile-four columns centered'>".$titre_recherche."</h1>";

	if (isset($contraintes_render))
	{
		echo "<h2>Contraintes<h2><ul>";
		foreach($contraintes_render as $titre => $valeur)
		{
			echo "<li><b>".$titre."</b> : ".$valeur."</li>"; 
		}
		echo "</ul>";
	}
	?>
	<div id="liste" class="row">
		<table class="ten columns centered">
			<?php
			foreach($adherents as $adherent)
			{
			?>
				<tr>
					<?php
					if (isset($adherent->bungalow))
						echo "<td class='one column'>".$adherent->bungalow->numero."</td>";
					?>
					<td class="three columns"><?php echo $adherent->nom; ?></td>
					<td class="two columns"><?php echo $adherent->prenom; ?></td>
					<td class="two columns">
						<?php echo anchor("backend/adherent/voir/".$adherent->id, "Consulter", array('class' => "tiny regular button")); ?>
					</td>
					<td class="two columns">
						<?php echo anchor("backend/adherent/modifier/".$adherent->id, "Modifier", array('class' => "tiny secondary button")); ?>
					</td>
					<td class="two columns">
						<?php echo anchor("backend/adherent/supprimer/".$adherent->id, "Supprimer",
							array(
								'class' => "tiny alert button",
								'onclick' => "suppression_adherent()",
								'target' => '_blank',
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

<?php echo js('showtime'); ?>