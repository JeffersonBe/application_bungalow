<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Représente les statistiques (basiques)
*
* @warning Les statistiques sont mises à jour
par mysql, car elles sont stockées dans des vues
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/
class Stats_model extends CI_Model {
	/**
	* Nombre d'éléments dans un groupe
	* @var int $nb;
	*/
	public $nb;
	/**
	* Pourcentage d'éléments du groupe par rapport au total
	* @var int $pourcentage
	*/
	public $pourcentage;

	function __construct()
	{
		parent::__construct();
	}

	/**
	* Sort les stats des écoles
	* @return objects array objets des résultats de la requête sur la vue
	*/
	function voir_ecoles()
	{
		$ecoles = array();

		$query = $this->db->get(
			'vue_stats_ecole',
		);

		foreach($query->result() as $ecole)
		{
			array_push($ecoles, $ecole);
		}

		return $ecoles;
	}

	function voir_sexes()
	/**
	* Sort les stats des sexes
	* @return objects array objets des résultats de la requête sur la vue
	*/
	{
		$sexes = array();

		$query = $this->db->get(
			'vue_stats_sexe',
		);

		foreach($query->result() as $sexe)
		{
			array_push($sexes, $sexe);
		}

		return $sexes;
	}
}