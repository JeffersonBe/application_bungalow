<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Représente les logs
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/
class Log_model extends CI_Model {
	/**
	* table
	*/
	public $table;
	/**
	* id de la ligne
	* @warning 11 chiffres max.
	* @note généré automatiquement par mysql
	* @var int $id
	*/
	public $id;
	/**
    * date de la dernière modification du profil de l'adhérent
	* @note exemple '2012-07-15 00:00:00'
	* @note Généré et mis à jour automatiquement par mysql
    * @var string $modification
    */
	public $modification;

	function __construct()
	{
		parent::__construct();
	}

	/**
	* Sort les logs de toutes les tables
	*
	* @param int $limite optionnel nombre limite de bungalows
	* @param int $offset optionnel offset (décalage)
	* @param string $ordre_index Index d'ordre (1 = id, 2 = adherent_id, 3 = modification, 4 = table)
	* @param string $ordre_direction optionnel direction selon laquelle s'effectue l'ordre ('desc' ou 'asc')
	* @return objects array array (objets adhérents des résultats de la requête, table, date modification)
	*/
	function charger_confondus($limite=30, $offset=0, $ordre_index=3, $ordre_direction='desc')
	{
		$query = $this->db->query('
			SELECT null as `id`, `id` as `adherent_id`, `modification`, "adherent" as `table`
			FROM `adherent`
			UNION
			SELECT `id`, `adherent_id`, `modification`, "compta" as `table`
			FROM `compta`
			UNION 
			SELECT  `id`, `adherent_id`, `modification`, "compta_sei" as `table`
			FROM `compta_sei`
			UNION
			SELECT  `id`, `adherent_id`, `modification`, "compta_wei" as `table`
			FROM `compta_wei`
			UNION
			SELECT  `id`, `adherent_id`, `modification`, "profil" as `table`
			FROM `profil`
			UNION
			SELECT  `id`, `adherent_id`, `modification`, "sei" as `table`
			FROM `sei`
			UNION
			SELECT  `id`, `adherent_id`, `modification`, "wei" as `table`
			FROM `wei`
			UNION
			SELECT  `id`, null as `adherent_id`, `modification`, "wei_bungalow" as `table`
			FROM `wei_bungalow`
			UNION
			SELECT  `id`, null as `adherent_id`, `modification`, "wei_equipe" as `table`
			FROM `wei_equipe`

			ORDER BY '.$ordre_index.' '.$ordre_direction.'
			LIMIT '.$offset.', '.$limite.'
		');
		
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}

		return $query->result();
	}
}