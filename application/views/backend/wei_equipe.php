<div id='main' class='row'>
	<?php
	if ($equipe)
	{
	?>
		<div class="row">
			<?php echo anchor("backend/wei/equipe/modifier/".$equipe->id, "Modifier", array("class" => "left button")); ?>
		</div>
		<div class="row">
			<ul>
				<?php
				if (!$equipe->hexa)
					echo "<li><b>Nom</b> : ".$equipe->nom."</li>";
				else
					echo "<li><b>Nom</b> : <span style='color: #".$equipe->hexa.";'>".$equipe->nom."</span></li>";
				?>
				<li><b>Couleur (code RGB hexadécimal)</b> : <?php echo $equipe->hexa; ?></li>
				<li><b>Dernière modification</b> : <?php echo $equipe->modification; ?></li>
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
		echo '<center><span class="alert label">Équipe inconnue</span></center>';
	}
	?>
</div>