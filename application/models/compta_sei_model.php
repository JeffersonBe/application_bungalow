<?php

/**
* Représente la comptabilité pour la SEI d'un adhérent du BDE
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/
class Compta_sei_model extends CI_Model {
	/**
	* id identifiant de la comptabilité SEI d'un adhérent de façon unique
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
	* Moyen de payement des bbq de la SEI
	* @warning 30 caractères max.
	* @var string $mode_payement
	*/
	public $mode_payement;
	/**
	* Les bbq ont-ils été payés ?
	* @var bool $bbq_paye
	*/
	public $bbq_paye;
	/**
	* Montant déjà payé
	* @var float $prix_paye
	*/
	public $prix_paye = 0.;
	/**
    * date de la dernière modification de la comptabilité SEI de l'adhérent
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
	* Enregistre la comptabilité SEI de l'adhérent dans la base de données
	* et retourne son id
	*
	* @return int id de la comptabilité SEI
	*/
	public function enregistrer()
	{
		$data = array(
			'adherent_id' => $this->adherent_id,
			'mode_payement' => $this->mode_payement,
			'bbq_paye' => (int) $this->bbq_paye,
			'prix_paye' => $this->prix_paye,
		);

		$this->db->insert('compta_sei', $data);

		return $this->db->insert_id();
	}

	/**
	* Met à jour la comptabilité SEI de l'adhérent dans la base de données
	*/
	public function mettre_a_jour()
	{
		$data = array(
			'mode_payement' => $this->mode_payement,
			'bbq_paye' => (int) $this->bbq_paye,
			'prix_paye' => $this->prix_paye,
		);

		$this->db->where('id', $id);
	}

	/**
	* Charge les variables d'instance avec les paramètres
	* de la comptabilité SEI d'un adhérent en allant chercher dans la base de données
	*
	* @param int id de la comptabilité SEI
	* @param int id de l'adhérent
	* @return Compta_sei_model objet compta
	*/
	public function charger($id=False, $adherent_id=False)
	{
		if ($id)
		{
			$query = $this->db->get_where(
				'compta_sei',
				array(
					'id' => $id
				)
			);
		}
		elseif ($adherent_id)
		{
			$query = $this->db->get_where(
				'compta_sei',
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
		$this->id = $row->id;
		$this->adherent_id = $row->adherent_id;
		$this->_adherent = $this->Adherent_model->charger($this->adherent_id);
		$this->mode_payement = $row->mode_payement;
		$this->bbq_paye = (bool) $row->bbq_paye;
		$this->prix_paye = $row->prix_paye;
		$this->modification = $row->modification;
		return clone $this;
	}
}