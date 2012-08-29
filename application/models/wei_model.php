<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Représente la WEI d'un adhérent du BDE
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/
class Wei_model extends CI_Model {
	/**
	* id identifiant de la WEI d'un adhérent de façon unique
	* @warning 11 chiffres max.
	* @note généré automatiquement par mysql
	* @var int $id
	*/
	public $id;
	/**
	* id identifiant de l'adhérent de façon unique
	* @warning 11 chiffres max.
	* @var int $adherent_id
	*/
	public $adherent_id;
	/**
	* objet de l'adhérent ayant l'id adherent_id
	* @var Adherent_model $_adherent
	*/
	private $_adherent;
	/**
	* L'adhérent est intéressé par le WEI ?
	* @var bool $interet
	*/
	public $interet;
	/**
	* L'adhérent va au WEI ?
	* @var bool $wei
	*/
	public $wei;
	/**
	* Clé du bungalow de l'adhérent
	* @warning 50 caractères max
	* @var string $clef
	*/
	public $clef;
	/**
	* État de la réservation du WEI
	* État possibles :
	* 0 : non inscrit
	* 1 : annulé
	* 2 : inscrit
	* 3 : payement effectué
	* @warning 1 chiffre max
	* @var int $etat_reservation
	*/
	public $etat_reservation;
	/**
	* id identifiant de le bungalow de façon unique
	* @warning 11 chiffres max.
	* @var int $bungalow_id
	*/
	public $bungalow_id;
	/**
	* objet du bungalow ayant l'id bungalow_id
	* @var Wei_bungalow_model $_bungalow
	*/
	private $_bungalow;
	/**
	* id identifiant de l'équipe de façon unique
	* @warning 11 chiffres max.
	* @var int $equipe_id
	*/
	public $equipe_id;
	/**
	* objet de l'équipe ayant l'id equipe_id
	* @var Wei_equipe_model $_equipe
	*/
	private $_equipe;
	/**
    * date de la dernière modification du wei
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
	* Combien de places reste-t-il au wei ?
	*
	* @note Fait la différence entre les capacité des bungalows et les personnes s'étant inscrites
	*       (pas forcément de bungalow déjà attribué)
	* @todo test
	* @return array clés : "places_restantes", "places_totales"
	*/
	public function places_restantes_wei()
	{
		$query = $this->db->query("
			SELECT sum( capacite ) - sum( participants ) AS places_restantes, sum( capacite ) AS places_totales
			FROM (
			(

			SELECT sum( capacite ) AS capacite, 0 AS participants
			FROM `wei_bungalow`
			)
			UNION ALL (

			SELECT 0 , COUNT( * ) AS participants
			FROM `wei`
			WHERE `wei` = 1
			)
			) AS T
		");

		$row = $query->row();

		return array(
			"places_restantes" => $row->places_restantes,
			"places_totales" => $row->places_totales,
		);
	}

	/**
	* Enregistre les données wei de l'adhérent dans la base de données
	* et retourne son id
	*
	* @return int id du  wei
	*/
	public function enregistrer()
	{
		$bungalow = $this->bungalow_id ? $this->bungalow_id : null;
		$equipe = $this->equipe_id ? $this->equipe_id : null;
		$data = array(
			'adherent_id' => $this->adherent_id,
			'interet' => (int) $this->interet, 
			'wei' => (int) $this->wei,
			'clef' => $this->clef,
			'etat_reservation' => $this->etat_reservation,
			'bungalow_id' => $bungalow,
			'equipe_id' => $equipe,
		);

		$this->db->insert('wei', $data);

		return $this->db->insert_id();
	}

	/**
	* met à jour les données wei de l'adhérent dans la base de données
	*/
	public function mettre_a_jour()
	{
		$bungalow = $this->bungalow_id ? $this->bungalow_id : null;
		$equipe = $this->equipe_id ? $this->equipe_id : null;
		$data = array(
			'interet' => (int) $this->interet, 
			'wei' => (int) $this->wei,
			'clef' => $this->clef,
			'etat_reservation' => $this->etat_reservation,
			'bungalow_id' => $bungalow,
			'equipe_id' => $equipe,
		);

		$this->db->where('id', $this->id);
		$this->db->update('wei', $data);
	}

	/**
	* Charge les variables d'instance avec les paramètres
	* du wei d'un adhérent en allant chercher dans la base de données
	*
	* @param int $id du wei
	* @param int $adherent_id id de l'adhérent
	* @return Wei_model objet wei
	*/
	public function charger($id=False, $adherent_id=False)
	{
		if ($id)
		{
			$query = $this->db->get_where(
				'wei',
				array(
					'id' => $id
				)
			);
		}
		elseif ($adherent_id)
		{
			$query = $this->db->get_where(
				'wei',
				array(
					'adherent_id' => $adherent_id
				)
			);
		}
		
		if ($query->num_rows() != 1)
		{
			return FALSE;
		}
		
		$row = $query->row();
		$this->id = (int) $row->id;
		$this->adherent_id = $row->adherent_id;
		$this->_adherent = $this->Adherent_model->charger($this->adherent_id);
		$this->interet = (bool) $row->interet;
		$this->wei = (bool) $row->wei;
		$this->clef = $row->clef;
		$this->etat_reservation = $row->etat_reservation;
		$this->bungalow_id = $row->bungalow_id;
		$this->_bungalow = $this->Wei_bungalow_model->charger($this->bungalow_id);
		$this->equipe_id = $row->equipe_id;
		$this->_equipe = $this->Wei_equipe_model->charger($this->equipe_id);
		$this->modification = $row->modification;
		return clone $this;
	}

	/**
	* Cherche des séjours wei selon des contraintes
	*
	* @param array $contraintes tableau associatif des contraintes $colonne => $recherche
	* @param int $limite optionnel nombre limite de de séjours wei
	* @param int $offset optionnel offset (décalage)
	* @return int array tableau des id des adhérents
	*         (permet de faire des inclusions, unions, exclusions, ...)
	*/
	public function chercher($contraintes, $limite=0, $offset=0)
	{
		$this->db->select('id');

		foreach($contraintes as $colonne => $recherche)
		{
			if ($recherche)
			{
				// %recherche%
				$this->db->like($colonne, $recherche);
			}
		}

		if ($limite)
			$this->db->limit($limite, $offset);

		$query = $this->db->get('wei');

		$resultat = array();

		if ($query->num_rows() == 0)
		{
			return $resultat;
		}

		foreach($query->result() as $wei)
		{
			array_push($resultat, (int) $wei->adherent_id);
		}

		return $resultat;
	}
}