<?php

/**
* Représente le profil d'un adhérent du BDE
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/
class Profil_model extends CI_Model {
	/**
	* id identifiant le profil d'un adhérent de façon unique
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
	* identifiant disi de l'adhérent
	* @warning 8 caractères max.
	* @var string $disi
	*/
	public $disi='';
	/**
	* adresse e-mail de l'adhérent
	* @warning 100 caractères max.
	* @var string $email
	*/
	public $email='';
	/**
	* date de naissance de l'adhérent
	* @note exemple '2012-06-15 00:00:00'
	* @var string $date_naissance
	*/
	public $date_naissance='';
	/**
	* lieu de naissance de l'adhérent
	* @warning 100 caractères max.
	* @var string $lieu_naissance
	*/
	public $lieu_naissance='';
	/**
	* numéro de téléphone portable de l'adhérent
	* @warning 15 caractères max.
	* @var string $portable
	*/
	public $portable='';
	/**
	* numéro de téléphone fixe de l'adhérent
	* @warning 15 caractères max.
	* @var string $fixe
	*/
	public $fixe='';
	/**
	* adresse de l'adhérent
	* @var string $adresse
	*/
	public $adresse='';
	/**
	* numéro de la fiche rentrée de l'adhérent
	* @warning 3 chiffres max.
	* @var int $fiche_rentree
	*/
	public $fiche_rentree=0;
	/**
	* régime alimentaire de l'adhérent
	* @var string $fiche_rentree
	*/
	public $regime='';
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
	* Enregistre le profil de l'adhérent dans la base de données
	* et retourne son id
	*
	* @return int id du profil
	*/
	public function enregistrer()
	{
		$data = array(
			'adherent_id' => $this->adherent_id,
			'disi' => $this->disi, 
			'email' => $this->email,
			'date_naissance' => $this->date_naissance,
			'lieu_naissance' => $this->lieu_naissance,
			'portable' => $this->portable,
			'fixe' => $this->fixe,
			'adresse' => $this->adresse,
			'fiche_rentree' => $this->fiche_rentree,
			'regime' => $this->regime,
		);

		$this->db->insert('profil', $data);

		return $this->db->insert_id();
	}

	/**
	* Met à jour le profil de l'adhérent dans la base de données
	*/
	public function mettre_a_jour()
	{
		$data = array(
			'disi' => $this->disi, 
			'email' => $this->email,
			'date_naissance' => $this->date_naissance,
			'lieu_naissance' => $this->lieu_naissance,
			'portable' => $this->portable,
			'fixe' => $this->fixe,
			'adresse' => $this->adresse,
			'fiche_rentree' => $this->fiche_rentree,
			'regime' => $this->regime,
		);

		$this->db->where('id', $id);
		$this->db->update('profil', $data);
	}

	/**
	* Charge les variables d'instance avec les paramètres
	* de le profil d'un adhérent en allant chercher dans la base de données
	*
	* @param int id du profil
	* @param int id de l'adhérent
	* @return Profil_model objet compta
	*/
	public function charger($id=False, $adherent_id=False)
	{
		if ($id)
		{
			$query = $this->db->get_where(
				'profil',
				array(
					'id' => $id
				)
			);
		}
		elseif ($adherent_id)
		{
			$query = $this->db->get_where(
				'profil',
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
		$this->disi = $row->disi;
		$this->email = $row->email;
		$this->date_naissance = $row->date_naissance;
		$this->lieu_naissance = $row->lieu_naissance;
		$this->portable = $row->portable;
		$this->fixe = $row->fixe;
		$this->adresse = $row->adresse;
		$this->fiche_rentree = $row->fiche_rentree;
		$this->regime = $row->regime;
		$this->modification = $row->modification;
		return clone $this;
	}

	/**
	* Cherche des profils adhérent selon des contraintes
	*
	* @param array tableau associatif des contraintes $colonne => $recherche
	* @param int optionnel nombre limite de comptabilités
	* @param int optionnel offset (décalage)
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
		$query = $this->db->get('profil');

		$resultat = array();

		if ($query->num_rows() == 0)
		{
			return $resultat;
		}

		foreach($query->result() as $profil)
		{
			array_push($resultat, $profil->adherent_id);
		}

		return $resultat;
	}
}