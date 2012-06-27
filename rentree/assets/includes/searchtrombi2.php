<?php
$nom='bonnaire';
$adresse = "https://trombi.it-sudparis.eu/result.php?nom=bonn&prenom=&telephone=&bureau=&civilite=&dept=&ecole=&envoyer.x=21&envoyer.y=15"; // adresse de la page à exploiter
//$resultat = @file_get_contents ($adresse); // récupérer le contenu de la page

//echo 'plouf'.substr_count($resultat,'r&eacute;ponses');

//echo empty(strstr('<td align="left" class="size16bold"> Pierre-Edouard MONTABRUN <br>',$resultat));


//connexion via page de login

$url1="https://cas.it-sudparis.eu:443/cas/login?service=https://trombi.it-sudparis.eu/&gateway=true";
$url2="https://trombi.it-sudparis.eu/result.php?nom=bonn";

$ckfile = tempnam ("/tmp", "CURLCOOKIE");

echo 'part 1';
/* STEP 2. visit the homepage to set the cookie properly */
$ch = curl_init ($url1);
curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec ($ch);
echo $output;
echo 'part2';
/* STEP 3. visit cookiepage.php */
$ch = curl_init($url2);
curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec ($ch);
echo 'part 3';
?>