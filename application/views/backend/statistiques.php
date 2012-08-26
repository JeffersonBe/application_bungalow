<div id="main" class="row">
	<div class="ten columns centered">
		<div class="panel">
			<h4>WEI</h4>
			<ul class="ten disc columns centered">
				<li><?php
					echo "Places restantes : ";
					echo ($stats_wei['places_restantes'] / $stats_wei['places_totales'])*100;
					echo " % (".$stats_wei['places_restantes']."/".$stats_wei['places_totales'].")";
				?></li>
				<li><?php
					echo "Remplissage : ";
					echo (1 - $stats_wei['places_restantes'] / $stats_wei['places_totales'])*100;
					echo " % (".($stats_wei['places_totales'] - $stats_wei['places_restantes'])."/".$stats_wei['places_totales'].")";
				?></li>
			</ul>
		</div>
		<div class="panel">
			<h4>TEM vs TSP</h4>
			<ul class="ten disc columns centered">
				<?php
				foreach($stats_ecoles as $ecole)
				{
					if ($ecole->ecole == 'tsp')
					{
						echo "<li>TSP : ".($ecole->pourcentage * 100)." % (".$ecole->nb.")";
					}
					elseif ($ecole->ecole == 'tem')
					{
						echo "<li>TEM : ".($ecole->pourcentage * 100)." % (".$ecole->nb.")";
					}
				}
				?>
			</ul>
		</div>
		<div class="panel">
			<h4>Homme vs Femme</h4>
			<ul class="ten disc columns centered">
				<?php
				foreach($stats_sexes as $sexe)
				{
					if ($sexe->sexe == 'm')
					{
						echo "<li>Hommes : ".($sexe->pourcentage * 100)." % (".$sexe->nb.")";
					}
					elseif ($sexe->sexe == 'f')
					{
						echo "<li>Femmes : ".($sexe->pourcentage * 100)." % (".$sexe->nb.")";
					}
				}
				?>
			</ul>
		</div>
	</div><!-- fin de 10 -->
</div><!-- fin de main -->