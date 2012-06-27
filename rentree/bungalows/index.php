<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="Identifier-URL" content=""/>
		<meta name="language" content="fr"/>
		<meta name="location" content="France"/>
		<meta name="Author" content="Jefferson Bonnaire"/>
		<meta name="Description" content="Réservation des Bugalows WEI 2011"/>
		<meta name="keywords" content="Réservation Bugalows 2012 Télécom SudParis Télécom Ecole de Management"/>
		<meta name="htdig-keywords" content=""/>
		<meta name="subject" content=""/>
		<meta name="Date-Creation-yyyymmdd" content="20120805"/>
		<meta name="Audience" content="all"/>
		<title>Réservation des Bugalows - WEI 2012 by Showtime</title>
		<link rel="stylesheet" media="screen" type="text/css" href="assets/css/style.css" />

		<script type="text/javascript" src="assets/js/jquery.js"></script>
		<script type="text/javascript" src="assets/js/jquery.qtip-1.0.0.min.js"></script>
		<script type="text/javascript" src="assets/js/animation.js"></script>
		<script type="text/javascript" src="assets/js/com.js"></script>
	</head>
	<body>
		<div id="full">
			<div id="bg">
				<div id='etoiles'>
					<div id='soleil'>
					</div>
					<div id='lune'>
					</div>
					<div id="train">
						<div id='quai'>
							<div id='panneau'>
							</div>
						</div>
					</div>
					<div id='train-contenu'>
						<form method="post" action="assets/includes/verif_inscription.php" id="bungalows_form">
							<label for="nom">Nom:</label>
								<input id="nom" name="nom" onkeyup="lookup_nom(this.value);" onFocus="$('#suggestions2').hide();" size="20" type="text" autocomplete="off" />
							<label for="nom">Prénom: </label>
								<input id="prenom" name="prenom" onkeyup="lookup_prenom(this.value);" onFocus="$('#suggestions1').hide();" size="20" type="text" autocomplete="off" />
							<input type="button" class="submit" id="submit1" value="Choisir mon Bungalow!" />
						</form>
							<div class="suggestionsBox1" id="suggestions1" style="display: none;">
								<img style="position: relative; top: -12px; left: 30px;" src="assets/img/upArrow.png" alt="upArrow" />
								<div class="suggestionList" id="autoSuggestionsList1">
								</div>
							</div>
							<div class="suggestionsBox2" id="suggestions2" style="display: none;">
								<img style="position: relative; top: -12px; left: 30px;" src="assets/img/upArrow.png" alt="upArrow" />
								<div class="suggestionList" id="autoSuggestionsList2">
								</div>
							</div>
					</div>
					<div id='panneau-contenu'>
					</div>
					<div id='fin-contenu'>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-20811018-1']);
		  _gaq.push(['_trackPageview']);

		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
	</body>
</html>