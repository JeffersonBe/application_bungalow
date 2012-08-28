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
		// Créer directement toutes les lignes dans les tables pour ne pas faire foirer les jointures
	}

	public function voir($adherent_id)
	{
		$adherent_id = (int) $adherent_id;

		$adherent_data = array(
			"disi" => "dupain_c"
		);

		$this->load->view('backend/header', array('titre' => 'Adhérent John Doe'));
		$this->load->view('backend/menu');
		$this->load->view('backend/adherent', $adherent_data);
		$this->load->view('backend/footer');
	}

	public function editer($adherent_id)
	{

	}
}