<?php
/***
* Helper des fichiers assets
* 
* Crée des fonctions pour router directement vers les bons fichiers assets
* Valable pour : css, js, images
**/

if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('css_url'))
{
	function css_url($nom)
	{
		return base_url().'assets/css/'.$nom.'.css';	
	}
}

if (!function_exists('css'))
{
	//Crée le HTML d'un CSS
	function css($nom)
	{
		return '<link rel="stylesheet" type="text/css" href="'.css_url($nom).'" />';
	}
}

if (!function_exists('js_url'))
{
	function js_url($nom)
	{
		return base_url().'assets/javascript/'.$nom.'.js';
	}
}

if (!function_exists('js'))
{
	//Crée le HTML d'un JS
	function js($nom)
	{
		return '<script type="text/javascript" src="'.js_url($nom).'"></script>';
	}
}

if (!function_exists('js_remote'))
{
	//Crée le HTML d'un JS distant
	function js_remote($url)
	{
		return '<script type="text/javascript" src="'.$url.'"></script>';
	}
}

if (!function_exists('img_url'))
{
	function img_url($nom)
	{
		return base_url().'assets/images/'.$nom;
	}
}

if (!function_exists('img'))
{
	//Crée le HTML d'une image
	function img($nom, $alt = '', $class = '')
	{
		return '<img src="'.img_url($nom).'" alt="'.$alt.'" class="'.$class.'" />';	
	}
}

?>