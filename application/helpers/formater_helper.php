<?php
/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/
// 15/08/2012 => 2012-08-15 00:00:01
function formater_date_bdd($str)
{
	$j = substr($str, 0, 2);
	$m = substr($str, 3, 2);
	$a = substr($str, 6, 4);
	return $a.'-'.$m.'-'.$j.' 00:00:01';
}

//  2012-08-15 00:00:01 => 15/08/2012
function formater_date_ecran($str)
{
	$a = substr($str, 0, 4);
	$m = substr($str, 5, 2);
	$j = substr($str, 8, 2);
	return $j.'/'.$m.'/'.$a;
}

function br2nl($string){
	return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
} 