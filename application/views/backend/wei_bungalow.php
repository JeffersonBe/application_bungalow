<div id='main' class='row'>
	<?php
	if ($bungalow)
	{
	?>
		<div class="row">
			<?php echo anchor("backend/wei/bungalow/modifier/".$bungalow->id, "Modifier", array("class" => "left button")); ?>
		</div>
		<div class="row">
			<ul>
				<li><b>Numéro</b> : <?php echo $bungalow->numero; ?></li>
				<li><b>Capacité</b> : <?php echo "(".$bungalow->places_prises_bungalow()."/".$bungalow->capacite.")"; ?></li>
				<li><b>Nom</b> : <?php echo $bungalow->nom; ?></li>
				<?php
				if ($equipe)
				{
					if ($equipe->hexa)
						echo "<li><b>Équipe</b> : <span style='color: #".$equipe->hexa.";'>$equipe->nom</span></li>";
					else
						echo "<li><b>Équipe</b> : ".$equipe->nom."</li>";
				}
				else
					echo "<li><b>Équipe</b> : <span class='alert label'>Sans équipe</span></li>";
				?>
				<li><b>Dernière modification</b> : <?php echo $bungalow->modification; ?></li>
				<li><b>Membres :</b>
					<ul style='margin-left: 100px'>
						<?php
						if ($membres)
						{
							foreach ($membres as $membre) {
								echo '<li>';
									echo anchor("backend/adherent/voir/".$membre->id, $membre->prenom." ".$membre->nom);
								echo '</li>';
							}
						}
						else
						{
							echo "<li>Aucun membre</li>";
						}
						?>
					</ul>
				</li>
			</ul>
		</div>
	<?php
	}
	else {
		echo '<center><span class="alert label">Bungalow inconnu</span></center>';
	}
	?>
</div>