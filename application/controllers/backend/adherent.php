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

		$this->form_validation->set_rules('nom', 'Nom', 'xss_clean');
		$this->form_validation->set_rules('prenom', 'Prénom', 'xss_clean');
		$this->form_validation->set_rules('ecole', 'École', 'exact_length[3]|xss_clean');
		$this->form_validation->set_rules('promotion', 'Promotion', 'is_natural|exact_length[4]|xss_clean');
		$this->form_validation->set_rules('sexe', 'Sexe', 'exact_length[1]|xss_clean');

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
			$titre_recherche = "";
			if ($this->input->post("nom"))
				$titre_recherche .= " Nom : ".$this->input->post('nom').".";
			if ($this->input->post("prenom"))
				$titre_recherche .= " Prénom : ".$this->input->post('prenom').".";
			if ($this->input->post("ecole"))
				$titre_recherche .= " École : ".strtoupper($this->input->post('ecole')).".";
			if ($this->input->post("promotion"))
				$titre_recherche .= " Promo : ".$this->input->post('promotion').".";
			if ($this->input->post("sexe") == 'f')
				$titre_recherche .= " Sexe : Femme.";
			elseif ($this->input->post("sexe") == 'm')
				$titre_recherche .= " Sexe : Homme.";

			$contraintes = array(
				"nom" => $this->input->post("nom"),
				"prenom" => $this->input->post("prenom"),
				"ecole" => $this->input->post("ecole"),
				"promo" => $this->input->post("promotion"),
				"sexe" => $this->input->post("sexe"),
			);

			$chercher = $this->Adherent_model->chercher($contraintes, 0, 0, 'nom', 'asc');
			$adherents = array();
			foreach($chercher as $adherent_id)
			{
				array_push($adherents, $this->Adherent_model->charger($adherent_id));
			}

			$data_liste = array(
				"titre_recherche" => "",
				"adherents" => $adherents,
			);

			$this->load->view('backend/header', array('titre' => 'Cotisants 2012 - 2015'));
			$this->load->view('backend/menu');
			$this->load->view('backend/liste', $data_liste);
			$this->load->view('backend/footer');
		}
	}
}