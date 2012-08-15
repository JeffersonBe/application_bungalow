<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Représente la SEI d'un adhérent du BDE
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/
class Sei_model extends CI_Model {
	/**
	* id identifiant de la SEI d'un adhérent de façon unique
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
	* L'adhérent mange au bbq du samedi ?
	* @var bool $bbq_sam
	*/
	public $bbq_sam;
	/**
	* L'adhérent mange au bbq du dimanche ?
	* @var bool $bbq_dim
	*/
	public $bbq_dim;
	/**
	* L'adhérent mange au bbq du lundi ?
	* @var bool $bbq_lun
	*/
	public $bbq_lun;
	/**
	* L'adhérent mange au bbq du mardi ?
	* @var bool $bbq_mar
	*/
	public $bbq_mar;
	/**
	* L'adhérent mange au bbq du mercredi ?
	* @var bool $bbq_mer
	*/
	public $bbq_mer;
	/**
	* L'adhérent mange au bbq du jeudi ?
	* @var bool $bbq_jeu
	*/
	public $bbq_jeu;
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
	* Enregistre les données sei de l'adhérent dans la base de données
	* et retourne son id
	*
	* @return int id de la sei
	*/
	public function enregistrer()
	{
		$data = array(
			'adherent_id' => $this->adherent_id,
			'bbq_sam' => (int) $this->bbq_sam, 
			'bbq_dim' => (int) $this->bbq_dim,
			'bbq_lun' => (int) $this->bbq_lun,
			'bbq_mar' => (int) $this->bbq_mar,
			'bbq_mer' => (int) $this->bbq_mer,
			'bbq_jeu' => (int) $this->bbq_jeu,
		);

		$this->db->insert('sei', $data);

		return $this->db->insert_id();
	}

	/**
	* met à jour les données sei de l'adhérent dans la base de données
	*/
	public function mettre_a_jour()
	{
		$data = array(
			'bbq_sam' => (int) $this->bbq_sam, 
			'bbq_dim' => (int) $this->bbq_dim,
			'bbq_lun' => (int) $this->bbq_lun,
			'bbq_mar' => (int) $this->bbq_mar,
			'bbq_mer' => (int) $this->bbq_mer,
			'bbq_jeu' => (int) $this->bbq_jeu,
		);

		$this->db->where('id', $this->id);
		$this->db->update('sei', $data);
	}

	/**
	* Charge les variables d'instance avec les paramètres
	* de la sei d'un adhérent en allant chercher dans la base de données
	*
	* @param int $id de la sei
	* @param int $adherent_id id de l'adhérent
	* @return Sei_model objet sei
	*/
	public function charger($id=False, $adherent_id=False)
	{
		if ($id)
		{
			$query = $this->db->get_where(
				'sei',
				array(
					'id' => $id
				)
			);
		}
		elseif ($adherent_id)
		{
			$query = $this->db->get_where(
				'sei',
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
		$this->bbq_sam = (bool) $row->bbq_sam;
		$this->bbq_dim = (bool) $row->bbq_dim;
		$this->bbq_lun = (bool) $row->bbq_lun;
		$this->bbq_mar = (bool) $row->bbq_mar;
		$this->bbq_mer = (bool) $row->bbq_mer;
		$this->bbq_jeu = (bool) $row->bbq_jeu;
		$this->modification = $row->modification;
		return clone $this;
	}

	/**
	* Permet de savoir qui mange un jour donné et si il a payé
	* @param string $jour ('sam'|'dim'|'lun'|'mar'|'mer'|'jeu')
	* @param string $ordre_key optionnel colonne selon laquelle s'effectue l'ordre
	* @param string $ordre_direction optionnel direction selon laquelle s'effectue l'ordre ('desc' ou 'asc')
	* @return object array objets contenant adherent, sei et compta_sei
	*                     des adhérent mangeant au bbq du jour voulu
	*/
	public function qui_mange($jour, $ordre_key='sei.id', $ordre_direction='desc')
	{
		$this->db->select('*');
		$this->db->from('sei');
		$this->db->join('adherent', 'adherent.id = sei.adherent_id');
		$this->db->join('compta_sei', 'compta_sei.adherent_id = sei.adherent_id');
		$this->db->where('bbq_'.$jour, 1);
		$this->db->order_by($ordre_key, $ordre_direction);
		$query = $this->db->get();

		return $query->result();
	}
}