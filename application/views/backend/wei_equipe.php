<div id='main' class='row'>
	<?php
	if ($equipe)
	{
	?>
		<ul>
			<li><b>Nom</b> : <?php echo $equipe->nom; ?></li>
			<li><b>Dernière modification</b> : <?php echo $equipe->modification; ?></li>
			<li><b>Membres :</b>
				<ul style='margin-left: 100px'>
					<?php
					if ($membres)
					{
						foreach ($membres as $membre) {
							$membre->prenom." ".$membre->nom;
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
	<?php
	}
	else {
		echo '<center><span class="alert label">Équipe inconnue</span></center>';
	}
	?>
</div>