<?php echo js('showtime'); ?>
<div id="main" class="row">
	<div class="ten columns centered">
		<div class='twelve centered columns'>
			<div id='chart_wei' style="display: inline-block;"></div>
			<div id='chart_ecoles' style="display: inline-block;"></div>
			<div id='chart_sexes' style="display: inline-block;"></div>
			<div id='chart_boursiers' style="display: inline-block;"></div>
		</div><br /><br />
		<div class="panel">
			<h4>WEI</h4>
			<ul class="ten disc columns centered">
				<li>Places restantes : <?php
					if ($stats_wei['places_totales'] != 0)
					{
						$wei_max_chart = $stats_wei['places_totales'];
						$wei_chart = $wei_max_chart - $stats_wei['places_restantes'];
						echo ($stats_wei['places_restantes'] / $stats_wei['places_totales'])*100;
						echo " % (".$stats_wei['places_restantes']."/".$stats_wei['places_totales'].")";
					}
					else
						$wei_chart = 1;
				?></li>
				<li>Remplissage : <?php
					if ($stats_wei['places_totales'] != 0)
					{
						echo (1 - $stats_wei['places_restantes'] / $stats_wei['places_totales'])*100;
						echo " % (".($stats_wei['places_totales'] - $stats_wei['places_restantes'])."/".$stats_wei['places_totales'].")";
					}
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
						$tsp_chart = $ecole->nb;
						echo "<li>TSP : ".($ecole->pourcentage * 100)." % (".$ecole->nb.")";
					}
					elseif ($ecole->ecole == 'tem')
					{
						$tem_chart = $ecole->nb;
						echo "<li>TEM : ".($ecole->pourcentage * 100)." % (".$ecole->nb.")";
					}
				}
				?>
			</ul>
		</div>
		<div class="panel">
			<h4>Hommes vs Femmes</h4>
			<ul class="ten disc columns centered">
				<?php
				foreach($stats_sexes as $sexe)
				{
					if ($sexe->sexe == 'm')
					{
						$hommes_chart = $sexe->nb;
						echo "<li>Hommes : ".($sexe->pourcentage * 100)." % (".$sexe->nb.")";
					}
					elseif ($sexe->sexe == 'f')
					{
						$femmes_chart = $sexe->nb;
						echo "<li>Femmes : ".($sexe->pourcentage * 100)." % (".$sexe->nb.")";
					}
				}
				?>
			</ul>
		</div>
		<div class="panel">
			<h4>Boursiers vs Non Boursiers</h4>
			<ul class="ten disc columns centered">
				<?php
				foreach($stats_boursiers as $pallier)
				{
					if ($pallier->pallier == '')
					{
						$non_boursiers_chart = $pallier->nb;
						echo "<li>Non boursiers : ".($pallier->pourcentage * 100)." % (".$pallier->nb.")";
					}
					elseif ($pallier->pallier == 'Boursier')
					{
						$boursiers_chart = $pallier->nb;
						echo "<li>Boursiers : ".($pallier->pourcentage * 100)." % (".$pallier->nb.")";
					}
				}
				?>
			</ul>
		</div>
	</div><!-- fin de 10 -->
</div><!-- fin de main -->
<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<?php
	if (!isset($tem_chart))
		$tem_chart = 0;
	if (!isset($tsp_chart))
		$tsp_chart = 0;
	if (!isset($hommes_chart))
		$hommes_chart = 0;
	if (!isset($femmes_chart))
		$femmes_chart = 0;
?>
<script type="text/javascript">
	// Load the Visualization API and the piechart package.
	google.load('visualization', '1.0', {'packages':['corechart', 'gauge']});;
	// Set a callback to run when the Google Visualization API is loaded.
	google.setOnLoadCallback(function(){ drawEcoles(<?php echo $tem_chart; ?>, <?php echo $tsp_chart; ?>) });
	google.setOnLoadCallback(function(){ drawSexes(<?php echo $hommes_chart; ?>, <?php echo $femmes_chart; ?>) });
	google.setOnLoadCallback(function(){ drawBoursiers(<?php echo $non_boursiers_chart; ?>, <?php echo $boursiers_chart; ?>) });
	google.setOnLoadCallback(function(){ drawWei(<?php echo $wei_chart; ?>) });
</script>