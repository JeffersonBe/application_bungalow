<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Identifier-URL" content=""/>
<meta name="language" content="fr"/>
<meta name="location" content="France"/>
<meta name="Author" content="Pierre-Edouard MONTABRUN"/>
<meta name="Description" content="Réservation des Bugalows WEI 2011"/>
<meta name="keywords" content="Réservation Bugalows 2011 Télécom SudParis Télécom Ecole de Management"/>
<meta name="htdig-keywords" content=""/>
<meta name="subject" content=""/>
<meta name="Date-Creation-yyyymmdd" content="20110805"/>
<meta name="Audience" content="all"/>
<link rel="stylesheet" media="screen" type="text/css" href="style.css" />
<title>Réservation des Bugalows - WEI 2011 by Hypnoz</title>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
	function lookup_nom(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions1').hide();
		} else {
			$.post("search1.php", {search1: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions1').show();
					$('#autoSuggestionsList1').html(data);
				}
			});
		}
	} // lookup
	
	function lookup_prenom(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions2').hide();
		} else {
			$.post("search2.php", {search2: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions2').show();
					$('#autoSuggestionsList2').html(data);
				}
			});
		}
	} // lookup
	
	function fill(x,y,z) {
		$('#nom').val(x);
		$('#prenom').val(y);
		setTimeout("$('#suggestions"+z+"').hide();", 200);
	}
</script>
</head>
<body>

<div>
		<form method="post" action="verif_inscription.php" id="bungalows_form">

 			<label for="nom">Nom:</label><input id="nom" name="nom" onkeyup="lookup_nom(this.value);" size="30" type="text" autocomplete="off" />		
		
		<div class="suggestionsBox1" id="suggestions1" style="display: none;">
 
 			<img style="position: relative; top: -12px; left: 30px;" src="img/upArrow.png" alt="upArrow" />
 
 			<div class="suggestionList" id="autoSuggestionsList1"></div>
 
 		</div>
		
		<label for="nom">Prénom:</label><input id="prenom" name="prenom" onkeyup="lookup_prenom(this.value);" size="30" type="text" autocomplete="off" />		
		
		<div class="suggestionsBox2" id="suggestions2" style="display: none;">
 
 			<img style="position: relative; top: -12px; left: 30px;" src="img/upArrow.png" alt="upArrow" />
 
 			<div class="suggestionList" id="autoSuggestionsList2"></div>
 
 		</div>
		<input type="submit" class="submit" value="Choisir mon Bungalow!" /><br/>
		</form>
 
</div>




</body>
</html>