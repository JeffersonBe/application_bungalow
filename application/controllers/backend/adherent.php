<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Gestion des adhérents
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Adherent extends CI_Controller {
	public function index()
	{
		$this->load->model('Adherent_model');

		$chercher = $this->Adherent_model->chercher(array('promo' => '2015'), 0, 0, 'nom', 'asc');
		$adherents = array();
		foreach($chercher as $adherent_id)
		{
			array_push($adherents, $this->Adherent_model->charger($adherent_id));
		}

		$data_liste = array(
			"titre_recherche" => "Cotisants 2012 - 2015",
			"adherents" => $adherents,
		);

		$this->load->view('backend/header', array('titre' => 'Cotisants 2012 - 2015'));
		$this->load->view('backend/menu');
		$this->load->view('backend/liste', $data_liste);
		$this->load->view('backend/footer');
	}

	public function chercher()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('Stats_model');
		$this->load->model('Wei_model');
		$this->load->model('Adherent_model');
		$this->load->model('Compta_model');
		$this->load->model('Profil_model');

		$this->form_validation->set_rules('nom', 'Nom', 'xss_clean');
		$this->form_validation->set_rules('prenom', 'Prénom', 'xss_clean');
		$this->form_validation->set_rules('ecole', 'École', 'exact_length[3]|xss_clean');
		$this->form_validation->set_rules('promotion', 'Promotion', 'is_natural|exact_length[4]|xss_clean');
		$this->form_validation->set_rules('sexe', 'Sexe', 'exact_length[1]|xss_clean');
		$this->form_validation->set_rules('prelevement', 'Prélèvement automatique', 'exact_length[3]|xss_clean');
		$this->form_validation->set_rules('boursier', 'Boursier', 'exact_length[3]|xss_clean');
		$this->form_validation->set_rules('disi', 'DISI', 'xss_clean|mysql_real_escape_string');
		$this->form_validation->set_rules('portable', 'Téléphone portable', 'xss_clean');
		$this->form_validation->set_rules('email', 'Adresse e-mail', 'valid_email|xss_clean');
		$this->form_validation->set_rules('regime', 'Régime', 'xss_clean');

		$this->form_validation->set_error_delimiters('<div class="alert-box alert">', '<a href="" class="close">&times;</a></div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data_accueil = array(
				"stats_wei" => $this->Wei_model->places_restantes_wei(),
				"stats_ecoles" => $this->Stats_model->voir_ecoles(),
				"stats_sexes" => $this->Stats_model->voir_sexes(),
			);

			$this->load->view('backend/header', array('titre' => 'Accueil'));
			$this->load->view('backend/menu');
			$this->load->view('backend/accueil', $data_accueil);
			$this->load->view('backend/footer');
		}
		else
		{
			$contraintes_render = array();
			if ($this->input->post("nom"))
				$contraintes_render['Nom'] = $this->input->post('nom');
			if ($this->input->post("prenom"))
				$contraintes_render['Prénom'] = $this->input->post('prenom');
			if ($this->input->post("ecole"))
				$contraintes_render['École'] = strtoupper($this->input->post('ecole'));
			if ($this->input->post("promotion"))
				$contraintes_render['Promo'] = $this->input->post('promotion');
			if ($this->input->post("sexe") == 'f')
				$contraintes_render['Sexe'] = "Femme";
			elseif ($this->input->post("sexe") == 'm')
				$contraintes_render['Sexe'] = "Homme";
			if ($this->input->post("prelevement"))
				$contraintes_render['Prélèvement automatique'] = $this->input->post('prelevement');
			if ($this->input->post("boursier"))
				$contraintes_render['Boursier'] = $this->input->post('boursier');
			if ($this->input->post("disi"))
				$contraintes_render['Identifiant DISI'] = $this->input->post('disi');
			if ($this->input->post("portable"))
				$contraintes_render['Téléphone portable'] = $this->input->post('portable');
			if ($this->input->post("email"))
				$contraintes_render['Adresse E-mail'] = $this->input->post('email');
			if ($this->input->post("regime"))
				$contraintes_render['Régime'] = $this->input->post('regime');

			$contraintes = array(
				"nom" => $this->input->post("nom"),
				"prenom" => $this->input->post("prenom"),
				"ecole" => $this->input->post("ecole"),
				"promo" => $this->input->post("promotion"),
				"sexe" => $this->input->post("sexe"),
			);
			$chercher_adherents = $this->Adherent_model->chercher($contraintes, 0, 0, 'nom', 'asc');

			$contraintes = array();
			if ($this->input->post('prelevement'))
			{
				if ($this->input->post('prelevement') == 'oui')
					$contraintes['prelevement'] = 1;
				else
					$contraintes['prelevement'] = 0;
			}
			if ($this->input->post('boursier'))
			{
				if ($this->input->post('boursier') == 'oui')
					$contraintes['pallier'] = 'Boursier';
				else
					$contraintes['pallier'] = null;
			}
			$chercher_compta = $this->Compta_model->chercher($contraintes, 0, 0, 'nom', 'asc');

			$contraintes = array(
				"disi" => $this->input->post("disi"),
				"portable" => $this->input->post("portable"),
				"email" => $this->input->post("email"),
				"regime" => $this->input->post("regime"),
			);
			$chercher_profils = $this->Profil_model->chercher($contraintes, 0, 0, 'nom', 'asc');

			$chercher = array_intersect($chercher_adherents, $chercher_compta, $chercher_profils);

			$adherents = array();
			foreach($chercher as $adherent_id)
			{
				array_push($adherents, $this->Adherent_model->charger($adherent_id));
			}

			$data_liste = array(
				"titre_recherche" => '',
				"adherents" => $adherents,
				"contraintes_render" => $contraintes_render,
			);

			$this->load->view('backend/header', array('titre' => 'Cotisants 2012 - 2015'));
			$this->load->view('backend/menu');
			$this->load->view('backend/liste', $data_liste);
			$this->load->view('backend/footer');
		}
	}

	public function nouveau()
	{
		// TODO Créer directement toutes les lignes dans les tables pour ne pas faire foirer les jointures
		$this->load->model('Adherent_model');
		$this->load->model('Profil_model');
		$this->load->model('Compta_model');
		$this->load->model('Compta_sei_model');
		$this->load->model('Compta_wei_model');
		$this->load->model('Sei_model');
		$this->load->model('Wei_model');
		$this->load->model('Wei_equipe_model');
		$this->load->model('Wei_bungalow_model');

		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('formater');

		$this->_set_rules();

		$this->form_validation->set_error_delimiters('<div class="alert-box alert">', '<a href="" class="close">&times;</a></div>');

		if ($this->form_validation->run() == FALSE)
		{
			$adherent_data = array(
				"liste_bungalow" => $this->Wei_bungalow_model->lister(0),
				"liste_equipes" => $this->Wei_equipe_model->lister(0),
			);

			$this->load->view('backend/header', array('titre' => 'Nouvel adhérent'));
			$this->load->view('backend/menu');
			$this->load->view('backend/adherent_editer', $adherent_data);
			$this->load->view('backend/footer');
		}
		else
		{
			$adherent_new = new $this->Adherent_model();
			$adherent_new->nom = $this->input->post('nom');
			$adherent_new->prenom = $this->input->post('prenom');
			$adherent_new->ecole = $this->input->post('ecole');
			$adherent_new->sexe = $this->input->post('sexe');
			$adherent_new->promo = $this->input->post('promotion');
			$adherent_id = $adherent_new->enregistrer();

			$profil_new = new $this->Profil_model();
			$profil_new->adherent_id = $adherent_id;
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
			$profil_new->enregistrer();

			$compta_new = new $this->Compta_model();
			$compta_new->adherent_id = $adherent_id;
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
			$compta_new->enregistrer();

			$compta_sei_new = new $this->Compta_sei_model();
			$compta_sei_new->adherent_id = $adherent_id;
			$compta_sei_new->bbq_paye = $this->input->post('bbq_paye');
			$compta_sei_new->mode_payement = $this->input->post('moyen_payement_sei');
			$compta_sei_new->prix_paye = $this->input->post('prix_paye_sei');
			$compta_sei_new->enregistrer();

			$compta_wei_new = new $this->Compta_wei_model();
			$compta_wei_new->adherent_id = $adherent_id;
			$compta_wei_new->tarif_intitule = $this->input->post('intitule_tarif_wei');
			if ($this->input->post('intitule_tarif_wei') == 'wei_sg_non_boursier')
				$compta_wei_new->prix = 200.;
			if ($this->input->post('intitule_tarif_wei') == 'wei_sg_boursier')
				$compta_wei_new->prix = 130.;
			if ($this->input->post('intitule_tarif_wei') == 'wei')
				$compta_wei_new->prix = 300.;
			$compta_wei_new->moyen_payement = $this->input->post('moyen_payement_wei');
			$compta_wei_new->caution = $this->input->post('caution_wei');
			$compta_wei_new->enregistrer();

			$sei_new = new $this->Sei_model();
			$sei_new->adherent_id = $adherent_id;
			$sei_new->bbq_sam = (bool) $this->input->post('bbq_sam');
			$sei_new->bbq_dim = (bool) $this->input->post('bbq_dim');
			$sei_new->bbq_lun = (bool) $this->input->post('bbq_lun');
			$sei_new->bbq_mar = (bool) $this->input->post('bbq_mar');
			$sei_new->bbq_mer = (bool) $this->input->post('bbq_mer');
			$sei_new->bbq_jeu = (bool) $this->input->post('bbq_jeu');
			$sei_new->enregistrer();

			$wei_new = new $this->Wei_model();
			$wei_new->adherent_id = $adherent_id;
			$wei_new->wei = (bool) $this->input->post('wei_go');
			$wei_new->clef = $this->input->post('clef');
			$wei_new->etat_reservation = $this->input->post('etat_reservation');
			if ($this->input->post('bungalow'))
				$wei_new->bungalow_id = $this->input->post('bungalow');
			if ($this->input->post('equipe'))
				$wei_new->equipe_id = $this->input->post('equipe');
			$wei_new->enregistrer();

			redirect("backend/adherent/voir/".$adherent_id);
		}
	}

	public function voir($adherent_id)
	{
		$this->load->model('Adherent_model');
		$this->load->model('Profil_model');
		$this->load->model('Compta_model');
		$this->load->model('Compta_sei_model');
		$this->load->model('Compta_wei_model');
		$this->load->model('Sei_model');
		$this->load->model('Wei_model');
		$this->load->model('Wei_equipe_model');
		$this->load->model('Wei_bungalow_model');

		$this->load->helper('formater');

		$adherent_id = (int) $adherent_id;
		$adherent = $this->Adherent_model->charger($adherent_id);

		$wei = $this->Wei_model->charger(False, $adherent_id);
		$adherent_data = array(
			"adherent" => $adherent,
			"profil" => $this->Profil_model->charger(False, $adherent_id),
			"compta" => $this->Compta_model->charger(False, $adherent_id),
			"compta_sei" => $this->Compta_sei_model->charger(False, $adherent_id),
			"compta_wei" => $this->Compta_wei_model->charger(False, $adherent_id),
			"sei" => $this->Sei_model->charger(False, $adherent_id),
			"wei" => $wei,
		);

		if ($wei)
		{
			$adherent_data["wei_equipe"] = $this->Wei_equipe_model->charger($wei->equipe_id);
			$adherent_data["wei_bungalow"] = $this->Wei_bungalow_model->charger($wei->bungalow_id);
		}

		if ($adherent)
			$this->load->view('backend/header', array('titre' => 'Adhérent '.$adherent->nom.' '.$adherent->prenom));
		else
			$this->load->view('backend/header', array('titre' => 'Adhérent Inconnu'));
		$this->load->view('backend/menu');
		$this->load->view('backend/adherent', $adherent_data);
		$this->load->view('backend/footer');
	}

	public function modifier($adherent_id)
	{
		$this->load->model('Adherent_model');
		$this->load->model('Profil_model');
		$this->load->model('Compta_model');
		$this->load->model('Compta_sei_model');
		$this->load->model('Compta_wei_model');
		$this->load->model('Sei_model');
		$this->load->model('Wei_model');
		$this->load->model('Wei_equipe_model');
		$this->load->model('Wei_bungalow_model');

		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('formater');

		$adherent_id = (int) $adherent_id;

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
			$compta_wei_new->caution = $this->input->post('caution_wei');
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

	public function supprimer($adherent_id)
	{
		$this->load->model('Adherent_model');

		$adherent_id = (int) $adherent_id;
		
		$adherent = $this->Adherent_model->charger($adherent_id);
		if ($adherent)
		{
			$adherent->supprimer();

			$adherent_supprimer_data = array(
				"adherent" => $adherent
			);

			$this->load->view('backend/header');
			$this->load->view('backend/menu');
			$this->load->view('backend/adherent_supprimer', $adherent_supprimer_data);
			$this->load->view('backend/footer');
		}
		else
			die("Adhérent inexistant");
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('nom', 'Nom', 'required|max_length[70]|xss_clean');
		$this->form_validation->set_rules('prenom', 'Prénom', 'required|max_length[70]|xss_clean');
		$this->form_validation->set_rules('ecole', 'École', 'required|exact_length[3]|xss_clean');
		$this->form_validation->set_rules('promotion', 'Promotion', 'required|is_natural|exact_length[4]|xss_clean');
		$this->form_validation->set_rules('sexe', 'Sexe', 'required|exact_length[1]|xss_clean');
		$this->form_validation->set_rules('disi', 'Login DISI', 'max_length[8]|xss_clean');
		$this->form_validation->set_rules('email', 'Adresse e-mail', 'valid_email|xss_clean');
		$this->form_validation->set_rules('date_naissance', 'Date de naissance', 'xss_clean|callback_date_naissance_check');
		$this->form_validation->set_rules('portable', 'Téléphone portable', 'max_length[15]|xss_clean');
		$this->form_validation->set_rules('fixe', 'Téléphone fixe', 'max_length[15]|xss_clean');
		$this->form_validation->set_rules('adresse', 'Adresse', 'nl2br|xss_clean');
		$this->form_validation->set_rules('lieu_naissance', 'Lieu de naissance', 'max_length[100]|xss_clean');
		$this->form_validation->set_rules('regime', 'Régime', 'xss_clean');
		$this->form_validation->set_rules('fiche_rentree', 'Fiche de rentrée', 'integer|intval|max_length[3]');
		$this->form_validation->set_rules('cotisant_bde', 'Cotisant BDE', 'integer|intval');
		$this->form_validation->set_rules('moyen_payement_cotiz', 'Moyen de payement de la cotisation', 'xss_clean|callback_moyen_payement_cotiz_check');
		$this->form_validation->set_rules('compte_sg', 'Compte à la Sogé', 'integer|intval');
		$this->form_validation->set_rules('rib', 'RIB', 'max_length[30]|xss_clean');
		$this->form_validation->set_rules('boursier', 'Boursier', 'integer|intval');
		$this->form_validation->set_rules('intitule_tarif_cotiz', 'Intitulé du tarif (cotisation)', 'xss_clean|callback_intitule_tarif_cotiz_check');
		$this->form_validation->set_rules('etat_prelevement_cotiz', 'État du prélèvement de la cotisation', 'xss_clean');
		$this->form_validation->set_rules('bbq_paye', 'BBQ payés', 'integer|intval');
		$this->form_validation->set_rules('moyen_payement_sei', 'Moyen de payement des BBQ', 'xss_clean|callback_moyen_payement_sei_check');
		$this->form_validation->set_rules('prix_paye_sei', 'Prix payé pour les BBQ', 'numeric|float');
		$this->form_validation->set_rules('intitule_tarif_wei', 'Intitulé du tarif (WEI)', 'xss_clean|callback_intitule_tarif_wei_check');
		$this->form_validation->set_rules('caution_wei', 'Caution prise', 'integer|intval');
		$this->form_validation->set_rules('moyen_payement_wei', 'Moyen de payement du WEI', 'xss_clean|callback_moyen_payement_wei_check');
		$this->form_validation->set_rules('bbq_sam', 'BBQ Samedi', 'integer|intval');
		$this->form_validation->set_rules('bbq_dim', 'BBQ Dimanche', 'integer|intval');
		$this->form_validation->set_rules('bbq_lun', 'BBQ Lundi', 'integer|intval');
		$this->form_validation->set_rules('bbq_mar', 'BBQ Mardi', 'integer|intval');
		$this->form_validation->set_rules('bbq_mer', 'BBQ Mercredi', 'integer|intval');
		$this->form_validation->set_rules('bbq_jeu', 'BBQ Jeudi', 'integer|intval');
		$this->form_validation->set_rules('wei_go', 'WEI', 'integer|intval');
		$this->form_validation->set_rules('clef', 'Clé du bungalow', 'max_length[50]|xss_clean');
		$this->form_validation->set_rules('etat_reservation', 'État de la réservation', 'xss_clean|callback_etat_reservation');
		$this->form_validation->set_rules('bungalow', 'Bungalow', 'intval');
		$this->form_validation->set_rules('equipe', 'Équipe', 'intval');
	}

	public function date_naissance_check($str)
	{
		$this->form_validation->set_message('date_naissance_check', 'Le %s champ Date de naissance doit être de la forme jj/mm/aaaa');
		if ($str == '')
			return TRUE;
		return (bool) preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $str);
	}

	public function moyen_payement_cotiz_check($str)
	{
		$this->form_validation->set_message('moyen_payement_cotiz_check', 'Moyen de payement de la cotisation non reconnu');
		return in_array($str, array("", "prelevement", "cheque", "liquide"));
	}

	public function intitule_tarif_cotiz_check($str)
	{
		$this->form_validation->set_message('intitule_tarif_cotiz_check', 'Intitulé du tarif de la cotisation non reconnu');
		return in_array($str, array("", "bde_sg", "bde"));
	}

	public function moyen_payement_sei_check($str)
	{
		$this->form_validation->set_message('moyen_payement_sei_check', 'Moyen de payement des BBQ non reconnu');
		return in_array($str, array("", "cheque", "liquide"));
	}

	public function intitule_tarif_wei_check($str)
	{
		$this->form_validation->set_message('intitule_tarif_wei_check', 'Intitulé du tarif du wei non reconnu');
		return in_array($str, array("", "wei_sg_non_boursier", "wei_sg_boursier", "wei"));
	}

	public function etat_reservation_check($str)
	{
		$this->form_validation->set_message('etat_reservation_check', 'État de la réservation non reconnu');
		return in_array($str, array("0", "1", "2", "3"));
	}
}