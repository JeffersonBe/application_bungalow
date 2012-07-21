<?php

/**
* Représente la comptabilité d'un adhérent du BDE
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/
class Compta_model extends CI_Model {
	/**
	* id identifiant de la comptabilité d'un adhérent de façon unique
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
	* L'adhérent est-il bien cotisant BDE ?
	* @var bool $cotisant_bde
	*/
	public $cotisant_bde;
	/**
	* Moyen de payement de la cotisation
	* @warning 20 caractères max.
	* @var string $moyen_payement_cotiz
	*/
	public $moyen_payement_cotiz;
	/**
	* L'adhérent est-il intéressé par la Société Générale ?
	* @var bool $interet_sg
	*/
	public $interet_sg;
	/**
	* L'adhérent a-t-il un compte à la Société Générale ?
	* @var string $compte_sg
	*/
	public $compte_sg;
	/**
	* Numéro de compte de l'adhérent pour la Société Générale
	* @warning 13 caractères max.
	* @var string $num_compte
	*/
	public $num_compte;
	/**
	* L'adhérent paye-t-il par prélèvement avec un compte à la Société Générale ?
	* @var bool $prelevement
	*/
	public $prelevement;
	/**
	* Pallier boursier de l'adhérent
	* @todo documenter les valeurs possibles
	* @warning 10 caractères max.
	* @var string $pallier
	*/
	public $pallier;
	/**
	* Intitulé du tarif de la cotisation
	* @todo documenter les valeurs possibles
	* @warning 30 caractères max.
	* @var string $tarif_intitule
	*/
	public $tarif_intitule;
	/**
	* Prix de la cotisation
	* @var float $prix
	*/
	public $prix;
	/**
	* État du prélèvement
	* @var string $etat_prelevement
	*/
	public $etat_prelevement;
	/**
    * date de la dernière modification de la comptabilité de l'adhérent
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
	* Enregistre la comptabilité de l'adhérent dans la base de données
	* et retourne son id
	*
	* @return int id de la comptabilité
	*/
	public function enregistrer()
	{
		$data = array(
			'adherent_id' => $this->adherent_id,
			'cotisant_bde' => (int) $this->cotisant_bde, 
			'moyen_payement_cotiz' => $this->moyen_payement_cotiz,
			'interet_sg' => (int) $this->interet_sg,
			'compte_sg' => $this->compte_sg,
			'num_compte' => $this->num_compte,
			'prelevement' => (int) $this->prelevement,
			'pallier' => $this->pallier,
			'tarif_intitule' => $this->tarif_intitule,
			'prix' => $this->prix,
			'etat_prelevement' => $this->etat_prelevement,
		);

		$this->db->insert('compta', $data);

		return $this->db->insert_id();
	}

	/**
	* Met à jour la comptabilité de l'adhérent dans la base de données
	*/
	public function mettre_a_jour()
	{
		$data = array(
			'cotisant_bde' => (int) $this->cotisant_bde, 
			'moyen_payement_cotiz' => $this->moyen_payement_cotiz,
			'interet_sg' => (int) $this->interet_sg,
			'compte_sg' => $this->compte_sg,
			'num_compte' => $this->num_compte,
			'prelevement' => (int) $this->prelevement,
			'pallier' => $this->pallier,
			'tarif_intitule' => $this->tarif_intitule,
			'prix' => $this->prix,
			'etat_prelevement' => $this->etat_prelevement,
		);

		$this->db->where('id', $id);
		$this->db->update('compta', $data);
	}

	/**
	* Charge les variables d'instance avec les paramètres
	* de la comptabilité d'un adhérent en allant chercher dans la base de données
	*
	* @param int $id de la comptabilité
	* @param int $adherent_id id de l'adhérent
	* @return Compta_model objet compta
	*/
	public function charger($id=False, $adherent_id=False)
	{
		if ($id)
		{
			$query = $this->db->get_where(
				'compta',
				array(
					'id' => $id
				)
			);
		}
		elseif ($adherent_id)
		{
			$query = $this->db->get_where(
				'compta',
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
		$this->cotisant_bde = (bool) $row->cotisant_bde;
		$this->moyen_payement_cotiz = $row->moyen_payement_cotiz;
		$this->interet_sg = (bool) $row->interet_sg;
		$this->compte_sg = (bool) $row->compte_sg;
		$this->num_compte = $row->num_compte;
		$this->prelevement = (bool) $row->prelevement;
		$this->pallier = $row->pallier;
		$this->tarif_intitule = $row->tarif_intitule;
		$this->prix = $row->prix;
		$this->etat_prelevement = $row->etat_prelevement;
		$this->modification = $row->modification;
		return clone $this;
	}

	/**
	* Cherche des comptabilités adhérent selon des contraintes
	*
	* @param array $contraintes tableau associatif des contraintes $colonne => $recherche
	* @param int $limite optionnel nombre limite de comptabilités
	* @param int $offset optionnel offset (décalage)
	* @return int array tableau des id des adhérents
	*         (permet de faire des inclusions, unions, exclusions, ...)
	*/
	public function chercher($contraintes, $limite=0, $offset=0)
	{
		$this->db->select('adherent_id');

		foreach($contraintes as $colonne => $recherche)
		{
			if ($recherche)
			{
				// %recherche%
				$this->db->like($colonne, $recherche);
			}
		}

		$this->db->limit($limite, $offset);
		$query = $this->db->get('compta');

		$resultat = array();

		if ($query->num_rows() == 0)
		{
			return $resultat;
		}

		foreach($query->result() as $compta)
		{
			array_push($resultat, $compta->adherent_id);
		}

		return $resultat;
	}
}