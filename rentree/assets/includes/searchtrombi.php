<?php
$nom='bonnaire';
$adresse = "https://cas.it-sudparis.eu:443/cas/login?service=https://trombi.it-sudparis.eu/&gateway=true"; // adresse de la page à exploiter
$resultat = @file_get_contents ($adresse); // récupérer le contenu de la page

echo 'plouf'.substr_count($resultat,'r&eacute;ponses');
echo $resultat;
//echo empty(strstr('<td align="left" class="size16bold"> Pierre-Edouard MONTABRUN <br>',$resultat));
?>