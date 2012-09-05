<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Gestion du WEI
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Wei extends CI_Controller {
	public function index()
	{
		$this->load->helper('form');

		$this->load->model('Wei_model');
		$this->load->model('Wei_equipe_model');
		$this->load->model('Wei_bungalow_model');

		$wei_data = array(
			"bungalows" => $this->Wei_bungalow_model->lister(0, 0, 'nom'),
			"equipes" => $this->Wei_equipe_model->lister(0, 0, 'nom'),
		);

		$this->load->view('backend/header', array('titre' => 'WEI'));
		$this->load->view('backend/menu');
		$this->load->view('backend/wei', $wei_data);
		$this->load->view('backend/footer');
	}
	
	public function equipe_voir($equipe_id)
	{
		$this->load->model('Wei_equipe_model');

		// $this->load->helper('formater');

		$equipe_id = (int) $equipe_id;
		$equipe = $this->Wei_equipe_model->charger($equipe_id);

		$equipe_data = array(
			"equipe" => $equipe,
		);
		
		if ($equipe)
		$equipe_data["membres"] = $equipe->lister_membres(0);

		if ($equipe)
			$this->load->view('backend/header', array('titre' => 'Équipe '.$equipe->nom));
		else
			$this->load->view('backend/header', array('titre' => 'Équipe inconnue'));
		$this->load->view('backend/menu');
		$this->load->view('backend/wei_equipe', $equipe_data);
		$this->load->view('backend/footer');
	}
	
	public function equipe_modifier($equipe_id)
	{
		$this->load->model('Wei_equipe_model');

		$this->load->library('form_validation');
		$this->load->helper('form');

		$adherent_id = intval($adherent_id);

		$adherent = $this->Adherent_model->charger($adherent_id);

		$this->_set_rules();

		$this->form_validation->set_error_delimiters('<div class="alert-box alert">', '<a href="" class="close">&times;</a></div>');

// 		var_dump($_POST);

		if ($this->form_validation->run() == FALSE)
		{
			$wei = $this->Wei_model->charger(False, $adherent_id);
			$adherent_data = array(
				"modifier" => True,
				"adherent" => $adherent,
				"profil" => $this->Profil_model->charger(False, $adherent_id),
				"compta" => $this->Compta_model->charger(False, $adherent_id),
				"compta_sei" => $this->Compta_sei_model->charger(False, $adherent_id),
				"compta_wei" => $this->Compta_wei_model->charger(False, $adherent_id),
				"sei" => $this->Sei_model->charger(False, $adherent_id),
				"wei" => $wei,
				"liste_bungalow" => $this->Wei_bungalow_model->lister(0),
				"liste_equipes" => $this->Wei_equipe_model->lister(0),
			);

			if ($adherent)
				$this->load->view('backend/header', array('titre' => 'Éditer adhérent '.$adherent->nom.' '.$adherent->prenom));
			else
				$this->load->view('backend/header', array('titre' => 'Éditer Adhérent Inconnu'));
			$this->load->view('backend/menu');
			$this->load->view('backend/adherent_editer', $adherent_data);
			$this->load->view('backend/footer');
		}
		else
		{
			$adherent_new = clone $adherent;
			$adherent_new->nom = $this->input->post('nom');
			$adherent_new->prenom = $this->input->post('prenom');
			$adherent_new->ecole = $this->input->post('ecole');
			$adherent_new->sexe = $this->input->post('sexe');
			$adherent_new->promo = $this->input->post('promotion');
			if ($adherent_new != $adherent);
				$adherent_new->mettre_a_jour();

			$profil = $this->Profil_model->charger(False, $adherent_id);
			$profil_new = clone $profil;
			$profil_new->disi = $this->input->post('disi');
			$profil_new->email = $this->input->post('email');
			if ($this->input->post('date_naissance'))
				$profil_new->date_naissance = formater_date_bdd($this->input->post('date_naissance'));
			else
				$profil_new->date_naissance = null;
			$profil_new->portable = $this->input->post('portable');
			$profil_new->fixe = $this->input->post('fixe');
			$profil_new->adresse = $this->input->post('adresse');
			$profil_new->lieu_naissance = $this->input->post('lieu_naissance');
			$profil_new->regime = $this->input->post('regime');
			$profil_new->fiche_rentree = $this->input->post('fiche_rentree');
			if ($profil_new != $profil);
				$profil_new->mettre_a_jour();

			$compta = $this->Compta_model->charger(False, $adherent_id);
			$compta_new = clone $compta;
			$compta_new->cotisant_bde = $this->input->post('cotisant_bde');
			$compta_new->moyen_payement_cotiz = $this->input->post('moyen_payement_cotiz');
			$compta_new->compte_sg = $this->input->post('compte_sg');
			$compta_new->rib = $this->input->post('rib');
			if ($this->input->post('moyen_payement_cotiz') == "prelevement")
				$compta_new->prelevement = True;
			else
				$compta_new->prelevement = False;
			$compta_new->pallier = $this->input->post('boursier') ? "Boursier" : "";
			$compta_new->tarif_intitule = $this->input->post('intitule_tarif_cotiz');
			if ($this->input->post('intitule_tarif_cotiz') == 'bde_sg')
				$compta_new->prix = 150.;
			if ($this->input->post('intitule_tarif_cotiz') == 'bde')
				$compta_new->prix = 200.;
			$compta_new->etat_prelevement = $this->input->post('etat_prelevement_cotiz');
			if ($compta_new != $compta);
				$compta_new->mettre_a_jour();

			$compta_sei = $this->Compta_sei_model->charger(False, $adherent_id);
			$compta_sei_new = clone $compta_sei;
			$compta_sei_new->bbq_paye = $this->input->post('bbq_paye');
			$compta_sei_new->mode_payement = $this->input->post('moyen_payement_sei');
			$compta_sei_new->prix_paye = $this->input->post('prix_paye_sei');
			if ($compta_sei_new != $compta_sei);
				$compta_sei_new->mettre_a_jour();

			$compta_wei = $this->Compta_wei_model->charger(False, $adherent_id);
			$compta_wei_new = clone $compta_wei;
			$compta_wei_new->tarif_intitule = $this->input->post('intitule_tarif_wei');
			if ($this->input->post('intitule_tarif_wei') == 'wei_sg_non_boursier')
				$compta_wei_new->prix = 200.;
			if ($this->input->post('intitule_tarif_wei') == 'wei_sg_boursier')
				$compta_wei_new->prix = 130.;
			if ($this->input->post('intitule_tarif_wei') == 'wei')
				$compta_wei_new->prix = 300.;
			$compta_wei_new->moyen_payement = $this->input->post('moyen_payement_wei');
			if ($compta_wei_new != $compta_wei);
				$compta_wei_new->mettre_a_jour();

			$sei = $this->Sei_model->charger(False, $adherent_id);
			$sei_new = clone $sei;
			$sei_new->bbq_sam = (bool) $this->input->post('bbq_sam');
			$sei_new->bbq_dim = (bool) $this->input->post('bbq_dim');
			$sei_new->bbq_lun = (bool) $this->input->post('bbq_lun');
			$sei_new->bbq_mar = (bool) $this->input->post('bbq_mar');
			$sei_new->bbq_mer = (bool) $this->input->post('bbq_mer');
			$sei_new->bbq_jeu = (bool) $this->input->post('bbq_jeu');
			if ($sei_new != $sei);
				$sei_new->mettre_a_jour();

			$wei = $this->Wei_model->charger(False, $adherent_id);
			$wei_new = clone $wei;
			$wei_new->wei = (bool) $this->input->post('wei_go');
			$wei_new->clef = $this->input->post('clef');
			$wei_new->etat_reservation = $this->input->post('etat_reservation');
			$wei_new->bungalow_id = $this->input->post('bungalow');
			$wei_new->equipe_id = $this->input->post('equipe');
			if ($wei_new != $wei);
				$wei_new->mettre_a_jour();

			redirect("backend/adherent/voir/".$adherent_id);
		}
	}
	
	public function equipe_supprimer($equipe_id)
	{

	}
}
