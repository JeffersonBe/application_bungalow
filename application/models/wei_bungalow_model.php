<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Représente un bungalow pour le WEI
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/
class Wei_bungalow_model extends CI_Model {
	/**
	* id identifiant le bungalow de façon unique
	* @warning 11 chiffres max.
	* @note généré automatiquement par mysql
	* @var int $id
	*/
	public $id;
	/**
	* id identifiant l'équipe du bungalow
	* @warning 11 chiffres max.
	* @var int $equipe_id
	*/
	public $equipe_id;
	/**
	* objet de l'équipe ayant l'id equipe_id
	* @var Equipe_model $_equipe
	*/
	private $_equipe;
	/**
	* Numéro du bungalow (d'après le camping)
	* @warning 50 caractères max.
	* @var string $numero
	*/
	public $numero;
	/**
	* Nom du bungalow
	* @warning 50 caractères max.
	* @var string $nom
	*/
	public $nom;
	/**
	* Capacité du bungalow
	* @warning 2 chiffres max.
	* @var int $capacite
	*/
	public $capacite;
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
	* Nombre de places prises dans le bungalow en cours
	* @todo test
	* @return int nombre de places prises
	*/
	public function places_prises_bungalow()
	{
		$this->db->select('wei_bungalow.id');
		$this->db->from('wei_bungalow');
		$this->db->join('wei', 'wei.bungalow_id = wei_bungalow.id');
		$this->db->where('wei_bungalow.id', $this->id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	/**
	* Enregistre le bungalow dans la base de données
	* et retourne son id
	*
	* @return int id de l'adhérent
	*/
	public function enregistrer()
	{
		$data = array(
			'equipe_id' => $this->equipe_id,
			'numero' => $this->numero,
			'nom' => $this->nom,
			'capacite' => $this->capacite,
		);

		$this->db->insert('wei_bungalow', $data);

		return $this->db->insert_id();
	}

	/**
	* Met à jour le bungalow dans la base de données
	*/
	public function mettre_a_jour()
	{
		$data = array(
			'equipe_id' => $this->equipe_id,
			'numero' => $this->numero,
			'nom' => $this->nom,
			'capacite' => $this->capacite,
		);

		$this->db->where('id', $this->id);
		$this->db->update('wei_bungalow', $data);
	}

	/**
	* Charge les variables d'instance avec les paramètres
	* d'un bungalow en allant chercher dans la base de données
	*
	* @param int $id du bungalow
	* @return Wei_bungalow_model objet bungalow
	*/
	public function charger($id)
	{
		$query = $this->db->get_where(
			'wei_bungalow',
			array(
				'id' => $id
			)
		);
		
		if ($query->num_rows() != 1)
		{
			return FALSE;
		}
		
		$row = $query->row();
		$this->id = (int) $row->id;
		$this->equipe_id = $row->equipe_id;
		$this->_equipe = $this->Wei_equipe_model->charger($this->equipe_id);
		$this->numero = $row->numero;
		$this->nom = $row->nom;
		$this->capacite = $row->capacite;
		$this->modification = $row->modification;
		
		return clone $this;
	}

	/**
	* Liste les bungalows selon des critères optionnels de
	* classement et de limite
	*
	* @param int $limite optionnel nombre limite de bungalows
	* @param int $offset optionnel offset (décalage)
	* @param string $ordre_key optionnel colonne selon laquelle s'effectue l'ordre
	* @param string $ordre_direction optionnel direction selon laquelle s'effectue l'ordre ('desc' ou 'asc')
	* @return Wei_bungalow_model array tableau des objets des bungalows
	*/
	public function lister($limite=30, $offset=0, $ordre_key='id', $ordre_direction='desc')
	{
		$this->db->select('id');
		$this->db->order_by($ordre_key, $ordre_direction);

		if ($limite)
			$this->db->limit($limite, $offset);

		$query = $this->db->get('wei_bungalow');
		
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}

		$resultat = array();
		foreach($query->result() as $wei_bungalow)
		{
			array_push($resultat, $this->charger($wei_bungalow->id));
		}

		return $resultat;
	}

	/**
	* Cherche des bungalows selon des contraintes
	*
	* @param array $contraintes tableau associatif des contraintes $colonne => $recherche
	* @param int $limite optionnel nombre limite de bungalows
	* @param int $offset optionnel offset (décalage)
	* @return int array tableau des id des bungalow
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

		$query = $this->db->get('wei_bungalow');

		$resultat = array();

		if ($query->num_rows() == 0)
		{
			return $resultat;
		}

		foreach($query->result() as $bungalow)
		{
			array_push($resultat, (int) $bungalow->id);
		}

		return $resultat;
	}

	/**
	* Supprime un bungalow et les données qui lui sont liées
	*/
	public function supprimer()
	{
		$this->db->where('id', $this->id);
		$this->db->delete('wei_bungalow');
	}
}