<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Représente une équipe WEI
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/
class Wei_equipe_model extends CI_Model {
	/**
	* id identifiant une équipe WEI de façon unique
	* @warning 11 chiffres max.
	* @note généré automatiquement par mysql
	* @var int $id
	*/
	public $id;
	/**
	* nom de l'équipe
	* @warning 50 caractères max.
	* @var string $nom
	*/
	public $nom;
	/**
    * date de la dernière modification de l'équipe
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
	* Enregistre l'équipe WEI dans la base de données
	* et retourne son id
	*
	* @return int id de l'équipe WEI
	*/
	public function enregistrer()
	{
		$data = array(
			'nom' => $this->nom, 
		);

		$this->db->insert('wei_equipe', $data);

		return $this->db->insert_id();
	}

	/**
	* Met à jour l'équipe WEI dans la base de données
	*/
	public function mettre_a_jour()
	{
		$data = array(
			'nom' => $this->nom, 
		);

		$this->db->where('id', $this->id);
		$this->db->update('wei_equipe', $data);
	}

	/**
	* Liste les équipes selon des critères optionnels de
	* classement et de limite
	*
	* @param int $limite optionnel nombre limite de bungalows
	* @param int $offset optionnel offset (décalage)
	* @param string $ordre_key optionnel colonne selon laquelle s'effectue l'ordre
	* @param string $ordre_direction optionnel direction selon laquelle s'effectue l'ordre ('desc' ou 'asc')
	* @return Wei_equipe_model array tableau des objets des équipes
	*/
	public function lister($limite=30, $offset=0, $ordre_key='id', $ordre_direction='desc')
	{
		$this->db->select('id');
		$this->db->order_by($ordre_key, $ordre_direction);

		if ($limite)
			$this->db->limit($limite, $offset);

		$query = $this->db->get('wei_equipe');
		
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}

		$resultat = array();
		foreach($query->result() as $wei_equipe)
		{
			array_push($resultat, $this->charger($wei_equipe->id));
		}

		return $resultat;
	}

	/**
	* Liste les membres d'un bungalow selon des critères optionnels de
	* classement et de limite
	*
	* @param int $limite optionnel nombre limite de bungalows
	* @param int $offset optionnel offset (décalage)
	* @param string $ordre_key optionnel colonne selon laquelle s'effectue l'ordre
	* @param string $ordre_direction optionnel direction selon laquelle s'effectue l'ordre ('desc' ou 'asc')
	* @return Adherent_model array tableau des objets des adhérents
	*/
	public function lister_membres($limite=30, $offset=0, $ordre_key='id', $ordre_direction='desc')
	{
		$this->db->select('*');
		$this->db->from('wei_equipe');
		$this->join('wei', 'wei.equipe_id = wei_equipe.id');
		$this->join('adherent', 'adherent.id = wei.adherent_id');
		$this->db->order_by($ordre_key, $ordre_direction);
		$this->db->limit($limite, $offset);
		$query = $this->db->get();
		
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}

		$resultat = array();
		foreach($query->result() as $adherent)
		{
			array_push($resultat, $adherent);
		}

		return $resultat;
	}

	/**
	* Cherche des équipes WEI selon des contraintes
	*
	* @param array $contraintes tableau associatif des contraintes $colonne => $recherche
	* @param int $limite optionnel nombre limite de équipes WEI
	* @param int $offset optionnel offset (décalage)
	* @return int array tableau des id des équipes WEI
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

		$this->db->limit($limite, $offset);
		$query = $this->db->get('wei_equipe');

		$resultat = array();

		if ($query->num_rows() == 0)
		{
			return $resultat;
		}

		foreach($query->result() as $equipe)
		{
			array_push($resultat, $equipe->id);
		}

		return $resultat;
	}

	/**
	* Charge les variables d'instance avec les paramètres
	* d'une équipe wei en allant chercher dans la base de données
	*
	* @param int $id equipe wei
	* @return Wei_equipe_model objet wei
	*/
	public function charger($id)
	{
		$query = $this->db->get_where(
			'wei_equipe',
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
		$this->nom = $row->nom;
		$this->modification = $row->modification;

		return clone $this;
	}

	/**
	* Supprime une équipe et les données qui lui sont liées
	*/
	public function supprimer()
	{
		$this->db->where('id', $this->id);
		$this->db->delete('wei_equipe');
	}
}