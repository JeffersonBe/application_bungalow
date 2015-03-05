<div id="main" class="row">
	<dl class="twelve columns sub-nav">
		<dt>Jour:</dt>
		<?php
		$jours_semaine = array(
			"sam" => "Samedi",
			"dim" => "Dimanche",
			"lun" => "Lundi",
			"mar" => "Mardi",
			"mer" => "Mercredi",
			"jeu" => "Jeudi"
		);
		foreach($jours_semaine as $ajour_semaine => $jour_semaine)
		{
			if ($ajour_semaine == $jour)
				echo '<dd class="active">'.anchor('backend/sei/index/'.$ajour_semaine, $jour_semaine).'</dd>';
			else
				echo '<dd>'.anchor('backend/sei/index/'.$ajour_semaine, $jour_semaine).'</dd>';
		}
		?>
	</dl>
	<div id="liste" class="row">
	<h3><small>Nombre de personnes attendues :</small> <?php echo count($adherents); ?></h3>
		<table class="ten columns centered">
			<tr>
				<th>Nom</th>
				<th>Prénom</th>
				<th></th>
				<th>Régime</th>
				<th>Payé ?</th>
			</tr>
			<?php
			foreach($adherents as $adherent)
			{
			?>
				<tr>
					<td><?php echo $adherent->nom; ?></td>
					<td><?php echo $adherent->prenom; ?></td>
					<td><?php echo anchor("backend/adherent/voir/".$adherent->id, "Consulter", array('class' => "tiny regular button")); ?>
					<?php
					if ($adherent->regime)
						echo '<td><span class="alert label">'.$adherent->regime.'</span></td>';
					else
						echo '<td></td>';
					if ($adherent->bbq_paye)
						echo '<td><span class="success label">Payé</span></td>';
					else
						echo '<td><span class="alert label">Non payé</span></td>';
					?>
				</tr>
			<?php
			}
			?>
		</table>
	</div>
</div>