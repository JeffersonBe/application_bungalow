<?php

function img_stat_sexe($pc_garcons)
{
//header ("Content-type: image/jpeg"); // L'image que l'on va créer est un jpeg
$pc_filles=100-$pc_garcons;
$degre=$pc_garcons*1.8;//passage en degré

// On charge d'abord les images
$source = imagecreatefrompng("assets/img/aiguille.png"); // L'aiguille est la source
$destination = imagecreatefromjpeg("assets/img/manwoman.jpg"); // Le fond est la destination
//imagesavealpha($source, true);


//on tourne ensuite l'aiguille
$source=imagerotate($source,$degre,-1);
imagealphablending($source,true);
// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
$largeur_source = imagesx($source);
$hauteur_source = imagesy($source);
$largeur_destination = imagesx($destination);
$hauteur_destination = imagesy($destination);

//On écrit les pourcentages au bon endroit
$noir = imagecolorallocate($destination, 0, 0, 0);
imagestring($destination, 5, 45, 180, $pc_garcons.'%', $noir);
imagestring($destination, 5, 325, 180, $pc_filles.'%', $noir);

// On veut placer l'aiguille au centre en bas, à noter que je n'ai pas pris en compte la rectification de position liée à la rotation (cosinus toussa toussa)
$destination_x = ($largeur_destination - $largeur_source)/2;
$destination_y =  30;

// On met l'aiguille dans l'image de destination (le fond)
imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);

// On affiche l'image de destination qui a été fusionnée dons le dossier cache pour qu'index.php puisse l'appeler sans avoir à calculer à chaque fois l'image.
imagejpeg($destination,'assets/img/cache/stat_sexe.jpg');

}


?>