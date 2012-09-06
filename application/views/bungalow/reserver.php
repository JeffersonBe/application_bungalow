<?php

$couleurs = array(
 8 => "rouge",
 9 => "vert",
 12 => "rose",
 7 => "orange",
 10 => "gris",
 6 => "bleuMarine",
 11 => "bleuCiel", 
)

?>


<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />
  <title>Showtime BDE | Bienvenue sur le site SEI/WEI</title>
  <!-- Included CSS Files -->
  <?php echo css('foundation'); ?>
  <?php echo css('bungalow'); ?>
  <link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>

  <!--[if lt IE 9]>
    <link rel="stylesheet" href="stylesheets/ie.css">
  <![endif]-->

  <?php echo js('modernizr.foundation'); ?>

  <!-- IE Fix for HTML5 Tags -->
  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
<body class="row">
    <div id="main" class="twelve columns">
        <div id="inscription" class="twelve column">
		<div class="twelve columns">
			<?php echo validation_errors(); ?>
			<?php echo form_open('bungalows/accueil/reserver'); ?>
			<h2 class="subheader text-center">Choissisez votre bungalow !</h2>
			<h3><?php echo anchor('bungalows/accueil/deconnecter', 'Se déconnecter'); ?></h3>
			<ul class="nine-up no-bullet">
			<?php
			foreach($bungalows as $bungalow)
			{
			?>
			 <li>
    			 <div class="bungalow three columns mobile-four">
    			 		<?php
    			 		if (array_key_exists($bungalow->_equipe->id, $couleurs))
							echo '<div class="bungalows '.$couleurs[$bungalow->_equipe->id].'">';
    			 		else
							echo '<div class="bungalows gris">';
						?>
							<div  class="informationBungalow">
								<p class="text-center"><span class="nombrePresent"><?php echo $bungalow->places_prises_bungalow(); ?></span>/<span class="nombreCapacite"><?php echo $bungalow->capacite; ?></span></p>
							</div>
						</div>
						<?php
						if (!$bungalow->nom)
							echo '<input type="text" name="nom_bungalow_'.$bungalow->id.'" placeholder="Donnez un nom au bungalow"/>';
						else
							echo $bungalow->nom;
						?>
						  <ul class="personnePresente" style="">
						  	  <?php
    						  if ($bungalow->membres)
							  {
							  	foreach($bungalow->membres as $membre)
									echo "<li>".$membre->prenom." ".$membre->nom."</li>";
							  }
							  ?>
						  </ul>
    			 		<?php
    			 		if (array_key_exists($bungalow->_equipe->id, $couleurs))
							echo '<div class="panneauSelection '.$couleurs[$bungalow->_equipe->id].'">';
    			 		else
							echo '<div class="panneauSelection gris">';
						?>
						<?php
						if (!$wei->bungalow_id && count(intval($bungalow->lister_membres(0))) < $bungalow->capacite)
							echo '<p class="text-center"><input type="radio" name="bungalows" value="'.$bungalow->id.'"/></p>';
						?>
						</div>
					</div>
			 </li>
			 <?php
			 }
			 ?>
			</ul>
			<?php
			if (!$wei->bungalow_id)
			{
			?>
			<div class="twelve columns">
    			<p class="text-center"><input type="submit" value="Let's Go" class="button large radius "></p>
			</div>
			<?php
			}
			?>
		</form>
</div><!-- fin de eight -->
</div><!-- fin de inscription -->
    </div><!-- fin de inscription -->
  <!-- Included JS Files -->
  <?php echo js('jquery.min'); ?>
  <?php echo js('foundation'); ?>
  <?php echo js('app'); ?>
</body>
</html>