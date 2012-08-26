<div id="main" class="row">
	<?php echo form_open('backend/adherent/chercher'); ?>
	<div class="six columns">
		<h1 class="ten subheader mobile-four columns centered">Rechercher</h1>
		<form>
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
				<div class="three mobile-two columns">
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
				<div class="three mobile-two columns">
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
			<div class="twelve columns">
				<label for="promotion" class="three mobile-two columns">
					<br />Promotion<br />
				</label>
				<select name="promotion">
					<option value="2012-2015">2012 - 2015</option>
					<option value="2011-2014">2011 - 2014</option>
					<option value="2010-2013">2010 - 2013</option>
				</select>
			</div>
			<div class="twelve columns"><br />
				<div class="six mobile-two columns">
					<?php
					$input = array(
						'name' => 'sexe',
						'id' => 'homme',
						'value' => 'homme',
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
						'value' => 'femme',
						'checked' => set_radio('sexe', 'femme'),
					);

					echo form_radio($input);
					echo form_label('Femme', 'femme', array('style' => 'display: inline;',));
					?>
				</div>
			</div>
			<div id="ajoutModfibtn" class="twelve columns">
				<a href="#" class="twelve small button columns">Chercher</a>
			</div>
		</form>
	</div>
	<div id="ajouter" class="six columns">
		<a href="#" class="twelve small button columns"><h1>Nouvel adhérent</h1></a>
	</div>
	<div id="stastiques" class="six columns"><br /><br />
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
	</div>
	<div id="activite" class="twelve columns">
		<br /><br />
		<h1 class="ten subheader mobile-four columns centered">Activit&eacute;s r&eacute;centes</h1>
		<table class="twelve mobile-for columns centered">
			<tr>
				<td class="four mobile-four columns">00-00-0000:00h00</td>
				<td class="two mobile-two columns">Aenean</td>
				<td class="two mobile-two columns">Ridiculus</td>
				<td class="two mobile-two columns">
					<a href="#" class="tiny secondary button">Consulter</a>
				</td>
				<td class="two mobile-two columns">
					<a href="#" class="tiny secondary button">Modifier</a>
				</td>
			</tr>
		</table>
	</div>
</div>