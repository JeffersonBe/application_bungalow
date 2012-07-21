<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Représente la comptabilité pour le WEI d'un adhérent du BDE
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/
class Compta_wei_model extends CI_Model {
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
	* Intitulé du tarif de la cotisation
	* @todo documenter les valeurs possibles
	* @warning 30 caractères max.
	* @var string $tarif_intitule
	*/
	public $tarif_intitule;
	/**
	* Prix du WEI
	* @var float $prix
	*/
	public $prix;
	/**
	* Moyen de payement du WEI
	* @warning 20 caractères max.
	* @var string $moyen_payement
	*/
	public $moyen_payement;
	/**
	* A-t-on une caution pour cet adhérent pour le WEI ?
	* @var bool $caution
	*/
	public $caution;
	/**
    * date de la dernière modification de la comptabilité WEI de l'adhérent
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
	* Enregistre la comptabilité WEI de l'adhérent dans la base de données
	* et retourne son id
	*
	* @return int id de la comptabilité WEI
	*/
	public function enregistrer()
	{
		$data = array(
			'adherent_id' => $this->adherent_id,
			'tarif_intitule' => $this->tarif_intitule,
			'prix' => $this->prix,
			'moyen_payement' => $this->moyen_payement,
			'caution' => (int) $this->caution,
		);

		$this->db->insert('compta_wei', $data);

		return $this->db->insert_id();
	}

	/**
	* Met à jour la comptabilité WEI de l'adhérent dans la base de données
	*/
	public function mettre_a_jour()
	{
		$data = array(
			'tarif_intitule' => $this->tarif_intitule,
			'prix' => $this->prix,
			'moyen_payement' => $this->moyen_payement,
			'caution' => (int) $this->caution,
		);

		$this->db->where('id', $id);
		$this->db->update('compta_wei', $data);
	}

	/**
	* Charge les variables d'instance avec les paramètres
	* de la comptabilité WEI d'un adhérent en allant chercher dans la base de données
	*
	* @param int $id de la comptabilité WEI
	* @param int $adherent_id id de l'adhérent
	* @return Compta_wei_model objet compta
	*/
	public function charger($id=False, $adherent_id=False)
	{
		if ($id)
		{
			$query = $this->db->get_where(
				'compta_wei',
				array(
					'id' => $id
				)
			);
		}
		elseif ($adherent_id)
		{
			$query = $this->db->get_where(
				'compta_wei',
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
		$this->tarif_intitule = $row->tarif_intitule;
		$this->moyen_payement = $row->moyen_payement;
		$this->caution = (bool) $row->caution;
		$this->prix = $row->prix;
		$this->modification = $row->modification;
		return clone $this;
	}
}