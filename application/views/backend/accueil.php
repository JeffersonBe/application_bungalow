<?php echo js('showtime'); ?>
<div id="main" class="row">
	<?php echo form_open('backend/adherent/chercher'); ?>
	<div class="six columns">
<!-- 		<h1 class="ten subheader mobile-four columns centered">Rechercher</h1> -->
		<form class='custom'>
		<fieldset>
		
		<legend>Rechercher</legend>
			<?php echo validation_errors(); ?> 

			<div class="six columns">
				<?php
				$input = array(
					'name' => 'nom',
					'value' => set_value('nom', ''),
					'placeholder' => 'Nom',
					'id' => 'nom',
				);
				echo form_label('Nom', 'nom');
				echo form_input($input);
				?>
			</div>
			<div class="six columns">
				<?php
				$input = array(
					'name' => 'prenom',
					'value' => set_value('prenom', ''),
					'placeholder' => 'Prénom',
					'id' => 'prenom',
				);
				echo form_label('Prénom', 'prenom');
				echo form_input($input);
				?>
			</div>
			<div class="twelve columns">
				<div class="six mobile-two columns">
					<?php
					$input = array(
						'name' => 'ecole',
						'id' => 'tsp',
						'value' => 'tsp',
						'checked' => set_radio('ecole', 'tsp'),
					);

					echo form_radio($input);
					echo form_label('TSP', 'tsp', array('style' => 'display: inline;',));
					?>
				</div>
				<div class="six mobile-two columns">
					<?php
					$input = array(
						'name' => 'ecole',
						'id' => 'tem',
						'value' => 'tem',
						'checked' => set_radio('ecole', 'tem'),
					);

					echo form_radio($input);
					echo form_label('TEM', 'tem', array('style' => 'display: inline;',));
					?>
				</div>
			</div>
			<div class="twelve columns" style='margin-bottom: 10px;'><br />
				<div class="six mobile-two columns">
					<?php
					$input = array(
						'name' => 'sexe',
						'id' => 'homme',
						'value' => 'm',
						'checked' => set_radio('sexe', 'homme'),
					);

					echo form_radio($input);
					echo form_label('Homme', 'homme', array('style' => 'display: inline;',));
					?>
				</div>
				<div class="six mobile-two columns">
					<?php
					$input = array(
						'name' => 'sexe',
						'id' => 'femme',
						'value' => 'f',
						'checked' => set_radio('sexe', 'femme'),
					);

					echo form_radio($input);
					echo form_label('Femme', 'femme', array('style' => 'display: inline;',));
					?>
				</div>
			</div>
			<input id='voir_plus_chercher' onclick='reveal("plus_chercher", "voir_plus_chercher")' type='button' class='tiny secondary button' value="Plus d'options »">
			<div id='plus_chercher'>
				<div class="twelve columns">
					<label for="promotion" class="three mobile-two columns">
						Promotion<br />
					</label>
					<select name="promotion">
						<option value="2015" <?php echo set_select('promotion', '2015', TRUE); ?> >2012 - 2015</option>
						<option value="2014" <?php echo set_select('promotion', '2014'); ?> >2011 - 2014</option>
						<option value="2013" <?php echo set_select('promotion', '2013'); ?> >2010 - 2013</option>
					</select>
				</div>
				<div class="twelve columns"><hr />
					<div class="six mobile-two columns">
						<?php
						$input = array(
							'name' => 'prelevement',
							'id' => 'prelevement_oui',
							'value' => 'oui',
							'checked' => set_radio('prelevement', 'prelevement_oui'),
						);

						echo form_radio($input);
						echo form_label('Avec prélèvement automatique', 'prelevement_oui', array('style' => 'display: inline;',));
						?>
					</div>
					<div class="six mobile-two columns">
						<?php
						$input = array(
							'name' => 'prelevement',
							'id' => 'prelevement_non',
							'value' => 'non',
							'checked' => set_radio('prelevement', 'prelevement_non'),
						);

						echo form_radio($input);
						echo form_label('Sans prélèvement automatique', 'prelevement_non', array('style' => 'display: inline;',));
						?>
					</div>
				</div>
				<div class="twelve columns"><br />
					<div class="six mobile-two columns">
						<?php
						$input = array(
							'name' => 'boursier',
							'id' => 'boursier_oui',
							'value' => 'oui',
							'checked' => set_radio('boursier', 'boursier_oui'),
						);

						echo form_radio($input);
						echo form_label('Boursier', 'boursier_oui', array('style' => 'display: inline;',));
						?>
					</div>
					<div class="six mobile-two columns">
						<?php
						$input = array(
							'name' => 'boursier',
							'id' => 'boursier_non',
							'value' => 'non',
							'checked' => set_radio('boursier', 'boursier_non'),
						);

						echo form_radio($input);
						echo form_label('Non boursier', 'boursier_non', array('style' => 'display: inline;',));
						?><br />
					</div>
				</div>
				<div class="twelve columns"><hr>
					<div class="six columns">
						<?php
						$input = array(
							'name' => 'disi',
							'value' => set_value('disi', ''),
							'placeholder' => 'Identifiant DISI',
							'id' => 'disi',
						);
						echo form_label('Identifiant DISI', 'disi');
						echo form_input($input);
						?>
					</div>
					<div class="six columns">
						<?php
						$input = array(
							'name' => 'portable',
							'value' => set_value('portable', ''),
							'placeholder' => 'Téléphone portable',
							'id' => 'portable',
						);
						echo form_label('Téléphone portable', 'portable');
						echo form_input($input);
						?>
					</div>
				</div>
				<div class="twelve columns">
					<?php
					$input = array(
						'name' => 'email',
						'value' => set_value('email', ''),
						'placeholder' => 'Adresse e-mail',
						'id' => 'email',
					);
					echo form_label('Adresse e-mail', 'email');
					echo form_input($input);
					?>
				</div>
				<div class="twelve columns">
					<?php
					$input = array(
						'name' => 'regime',
						'value' => set_value('regime', ''),
						'placeholder' => 'Halal, Casher, Végétarien, ...',
						'id' => 'regime',
					);
					echo form_label('Régime', 'regime');
					echo form_input($input);
					?>
				</div>
			</div>
			<hr><div id="chercherbtn" class="six columns">
				<?php
				$input = array(
					'name' => 'submit',
					'value' => 'Chercher',
					'class' => 'twelve small button columns',
				);

				echo form_submit($input);
				?>
			</div>
			<div id="viderbtn" class="six columns">
				<?php
				$input = array(
					'name' => 'reset',
					'value' => 'Vider la recherche',
					'class' => 'twelve small alert button columns',
					'style' => 'margin-bottom: 10px;',
				);

				echo form_reset($input);
				echo form_close();
				?>
			</div>
		</fieldset>
		</form>
	</div>
	<div id="ajouter" class="six columns">
		<?php echo anchor("backend/adherent/nouveau", "Nouvel adhérent", array('class'=> "twelve large button columns")); ?>
	</div>
	<div id="stastiques" class="six columns"><br /><br />
		<div class='twelve centered columns'>
			<div id='chart_wei' style="display: inline-block;"></div>
			<div id='chart_ecoles' style="display: inline-block;"></div>
			<div id='chart_sexes' style="display: inline-block;"></div>
		</div><br /><br />
		<input type='button' class='secondary button' onclick='toggle("plus_stats")' value='Plus de stats »' />
		<br /><br />
		<div id='plus_stats'>
			<div class="panel">
				<h4>WEI</h4>
				<ul class="ten disc columns centered">
					<li>Places restantes : <?php
						if ($stats_wei['places_totales'] != 0)
						{
							$wei_chart = (1 - $stats_wei['places_restantes'] / $stats_wei['places_totales'])*100;
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
			</div>
	</div>
	<div id="activite" class="twelve columns">
		<br /><br />
		<h1 class="ten subheader mobile-four columns centered">Activit&eacute;s r&eacute;centes</h1><br />
		<table class="twelve mobile-for columns centered">

			<tr>
				<th class="two mobile-two columns">Date</th>
				<th class="two mobile-two columns">Table</th>
				<th class="four mobile-four columns">Entité</th>
				<th class="two mobile-two columns"></th>
				<td class="two mobile-two columns"></th>
			</tr>
			<?php
			foreach($logs as $log)
			{
			?>
				<tr>
					<td class="two mobile-two columns"><?php echo $log->modification; ?></td>
					<td class="two mobile-two columns"><?php echo $log->table; ?></td>
					<td class="four mobile-four columns"><?php echo $log->entite; ?></td>
					<td class="two mobile-two columns">
						<?php echo anchor($log->consulter, "Consulter", array("class" =>"tiny button")); ?>
					</td>
					<td class="two mobile-two columns">
						<?php echo anchor($log->modifier, "Modifier", array("class" =>"tiny secondary button")); ?>
					</td>
				</tr>
			<?php
			}
			?>
		</table>
	</div>
</div>
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
	google.setOnLoadCallback(function(){ drawWei(<?php echo $wei_chart; ?>) });

	$('#plus_stats').hide();
	$('#plus_chercher').hide();
</script>