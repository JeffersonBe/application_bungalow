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
			"bungalows" => $this->Wei_bungalow_model->lister(0, 0, 'nom', 'asc'),
			"equipes" => $this->Wei_equipe_model->lister(0, 0, 'nom', 'asc'),
		);

		$this->load->view('backend/header', array('titre' => 'WEI'));
		$this->load->view('backend/menu');
		$this->load->view('backend/wei', $wei_data);
		$this->load->view('backend/footer');
	}
	
	public function chercher()
	{
		$this->load->model('Adherent_model');
		$this->load->model('Wei_model');
		$this->load->model('Wei_equipe_model');
		$this->load->model('Wei_bungalow_model');
		
		$this->load->library('form_validation');
		$this->load->helper('form');

		$this->form_validation->set_rules('numero', 'Numéro', 'xss_clean');
		$this->form_validation->set_rules('uniquement_sans_bungalow', 'Uniquement sans bungalow', 'intval');

		$this->form_validation->set_error_delimiters('<div class="alert-box alert">', '<a href="" class="close">&times;</a></div>');

		if ($this->form_validation->run() == FALSE)
		{
			$wei_data = array(
				"bungalows" => $this->Wei_bungalow_model->lister(0, 0, 'numero'),
				"equipes" => $this->Wei_equipe_model->lister(0, 0, 'nom'),
			);

			$this->load->view('backend/header', array('titre' => 'WEI'));
			$this->load->view('backend/menu');
			$this->load->view('backend/accueil', $wei_data);
			$this->load->view('backend/footer');
		}
		else
		{
			$contraintes_bungalow = array(
				"numero" => $this->input->post("numero"),
			);
			
			$contraintes_wei = array(
				"wei" => 1,
			);
			
			if ($this->input->post("uniquement_sans_bungalow"))
				$chercher_wei = $this->Wei_model->chercher($contraintes_wei, array('bungalow_id' => null), 0, 0);
			else
				$chercher_wei = $this->Wei_model->chercher($contraintes_wei, array(), 0, 0);

			if ($this->input->post("numero"))
			{
				$chercher_bungalow = $this->Wei_bungalow_model->chercher($contraintes_bungalow, 0, 0);
				$chercher = array_intersect($chercher_wei, $chercher_bungalow);
			}
			else
				$chercher = $chercher_wei;

			$adherents = array();
			foreach($chercher as $adherent_id)
			{
				$adherent = $this->Adherent_model->charger($adherent_id);
				$wei = $this->Wei_model->charger(False, $adherent_id);
				if ($wei->bungalow_id)
					$adherent->bungalow = $this->Wei_bungalow_model->charger($wei->bungalow_id);
				array_push($adherents, $adherent);
			}
			
			$contraintes_render = array();
			$contraintes_render['WEI'] = 'Oui';
			if ($this->input->post("uniquement_sans_bungalow"))
				$contraintes_render['Uniquement sans bungalow'] = "Oui";
			if ($this->input->post("numero"))
				$contraintes_render['Numéro'] = $this->input->post("numero");

			$data_liste = array(
				"adherents" => $adherents,
				"contraintes_render" => $contraintes_render,
			);

			$this->load->view('backend/header', array('titre' => 'Recherche participants WEI'));
			$this->load->view('backend/menu');
			$this->load->view('backend/liste', $data_liste);
			$this->load->view('backend/footer');
		}
	}
	
	public function equipe_voir($equipe_id)
	{
		$this->load->model('Wei_equipe_model');

		// $this->load->helper('formater');

		$equipe_id = intval($equipe_id);
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

		$equipe_id = intval($equipe_id);

		$equipe = $this->Wei_equipe_model->charger($equipe_id);

		$this->_equipe_set_rules();

		$this->form_validation->set_error_delimiters('<div class="alert-box alert">', '<a href="" class="close">&times;</a></div>');

// 		var_dump($_POST);

		if ($this->form_validation->run() == FALSE)
		{
			$wei = $this->Wei_equipe_model->charger($equipe_id);
			$equipe_data = array(
				"modifier" => True,
				"equipe" => $equipe,
			);

			if ($equipe)
				$this->load->view('backend/header', array('titre' => 'Éditer Équipe '.$equipe->nom));
			else
				$this->load->view('backend/header', array('titre' => 'Éditer Équipe Inconnue'));
			$this->load->view('backend/menu');
			$this->load->view('backend/wei_equipe_editer', $equipe_data);
			$this->load->view('backend/footer');
		}
		else
		{
			$equipe->nom = $this->input->post('nom');
			$equipe->hexa = $this->input->post('hexa');
			$equipe->mettre_a_jour();

			redirect("backend/wei/equipe/voir/".$equipe_id);
		}
	}
	
	public function equipe_nouveau()
	{
		$this->load->model('Wei_equipe_model');

		$this->load->library('form_validation');
		$this->load->helper('form');

		$this->_equipe_set_rules();

		$this->form_validation->set_error_delimiters('<div class="alert-box alert">', '<a href="" class="close">&times;</a></div>');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('backend/header', array('titre' => 'Nouvelle équipe WEI'));
			$this->load->view('backend/menu');
			$this->load->view('backend/wei_equipe_editer');
			$this->load->view('backend/footer');
		}
		else
		{
			$equipe = new $this->Wei_equipe_model();
			$equipe->nom = $this->input->post('nom');
			$equipe->hexa = $this->input->post('hexa');
			$equipe_id = $equipe->enregistrer();

			redirect("backend/wei/equipe/voir/".$equipe_id);
		}
	}
	
	public function equipe_supprimer($equipe_id)
	{
		$this->load->model('Wei_equipe_model');

		$equipe_id = intval($equipe_id);
		
		$equipe = $this->Wei_equipe_model->charger($equipe_id);
		if ($equipe)
		{
			$equipe->supprimer();

			$equipe_supprimer_data = array(
				"equipe" => $equipe
			);

			$this->load->view('backend/header');
			$this->load->view('backend/menu');
			$this->load->view('backend/wei_equipe_supprimer', $equipe_supprimer_data);
			$this->load->view('backend/footer');
		}
		else
			die("Équipe inexistante");
	}
	
	public function bungalow_voir($bungalow_id)
	{
		$this->load->model('Wei_equipe_model');
		$this->load->model('Wei_bungalow_model');
		$bungalow_id = intval($bungalow_id);
		$bungalow = $this->Wei_bungalow_model->charger($bungalow_id);

		$bungalow_data = array(
			"bungalow" => $bungalow,
			"equipe" => $this->Wei_equipe_model->charger($bungalow->equipe_id),
		);
		
		if ($bungalow)
			$bungalow_data["membres"] = $bungalow->lister_membres(0);

		if ($bungalow)
			$this->load->view('backend/header', array('titre' => 'Bungalow '.$bungalow->numero.' '.$bungalow->nom));
		else
			$this->load->view('backend/header', array('titre' => 'Bungalow inconnu'));
		$this->load->view('backend/menu');
		$this->load->view('backend/wei_bungalow', $bungalow_data);
		$this->load->view('backend/footer');
	}
	
	public function bungalow_modifier($bungalow_id)
	{
		$this->load->model('Wei_bungalow_model');
		$this->load->model('Wei_equipe_model');

		$this->load->library('form_validation');
		$this->load->helper('form');

		$bungalow_id = intval($bungalow_id);

		$bungalow = $this->Wei_bungalow_model->charger($bungalow_id);

		$this->_bungalow_set_rules();

		$this->form_validation->set_error_delimiters('<div class="alert-box alert">', '<a href="" class="close">&times;</a></div>');

// 		var_dump($_POST);

		if ($this->form_validation->run() == FALSE)
		{
			$wei = $this->Wei_bungalow_model->charger($bungalow_id);
			$bungalow_data = array(
				"modifier" => True,
				"bungalow" => $bungalow,
				"liste_equipes" => $this->Wei_equipe_model->lister(0, 0, 'nom', 'asc')
			);

			if ($bungalow)
				$this->load->view('backend/header', array('titre' => 'Éditer Bungalow '.$bungalow->numero.' '.$bungalow->nom));
			else
				$this->load->view('backend/header', array('titre' => 'Éditer Bungalow Inconnu'));
			$this->load->view('backend/menu');
			$this->load->view('backend/wei_bungalow_editer', $bungalow_data);
			$this->load->view('backend/footer');
		}
		else
		{
			$bungalow->numero = $this->input->post('numero');
			$bungalow->nom = $this->input->post('nom');
			$bungalow->capacite = $this->input->post('capacite');
			if ($this->input->post('equipe'))
				$bungalow->equipe_id = $this->input->post('equipe');
			else
				$bungalow->equipe_id = null;
			$bungalow->mettre_a_jour();

			redirect("backend/wei/bungalow/voir/".$bungalow_id);
		}
	}
	
	public function bungalow_nouveau()
	{
		$this->load->model('Wei_bungalow_model');
		$this->load->model('Wei_equipe_model');

		$this->load->library('form_validation');
		$this->load->helper('form');

		$this->_bungalow_set_rules();

		$this->form_validation->set_error_delimiters('<div class="alert-box alert">', '<a href="" class="close">&times;</a></div>');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('backend/header', array('titre' => 'Nouveau bungalow'));
			$this->load->view('backend/menu');
			$this->load->view('backend/wei_bungalow_editer', array("liste_equipes" => $this->Wei_equipe_model->lister(0, 0, 'nom', 'asc')));
			$this->load->view('backend/footer');
		}
		else
		{
			$bungalow = new $this->Wei_bungalow_model();
			$bungalow->numero = $this->input->post('numero');
			$bungalow->nom = $this->input->post('nom');
			$bungalow->capacite = $this->input->post('capacite');
			if ($this->input->post('equipe'))
				$bungalow->equipe_id = $this->input->post('equipe');
			else
				$bungalow->equipe_id = 0;
			$bungalow_id = $bungalow->enregistrer();

			redirect("backend/wei/bungalow/voir/".$bungalow_id);
		}
	}
	
	public function bungalow_supprimer($bungalow_id)
	{
		$this->load->model('Wei_bungalow_model');
		$this->load->model('Wei_equipe_model');

		$bungalow_id = intval($bungalow_id);
		
		$bungalow = $this->Wei_bungalow_model->charger($bungalow_id);
		if ($bungalow)
		{
			$bungalow->supprimer();

			$bungalow_supprimer_data = array(
				"bungalow" => $bungalow
			);

			$this->load->view('backend/header');
			$this->load->view('backend/menu');
			$this->load->view('backend/wei_bungalow_supprimer', $bungalow_supprimer_data);
			$this->load->view('backend/footer');
		}
		else
			die("Bungalow inexistant");
	}
	
	public function generer_pass($adherent_id)
	{
		$adherent_id = intval($adherent_id);
		
		$this->load->model('Adherent_model');
		$this->load->model('Wei_model');
		$this->load->model('Wei_bungalow_model');
		$this->load->model('Wei_equipe_model');
		
		$wei = $this->Wei_model->charger(False, $adherent_id);
		$wei->mdp = $this->nouveau_pass();
		$wei->mettre_a_jour();
		
		redirect('backend/adherent/voir/'.$adherent_id);
	}
	
	public function nouveau_pass()
	{
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    for ($i = 0; $i < 15; $i++) {
	        $n = rand(0, strlen($alphabet)-1); //use strlen instead of count
	        $pass[$i] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	private function _equipe_set_rules()
	{
		$this->form_validation->set_rules('nom', 'Nom', 'required|max_length[50]|xss_clean');
		$this->form_validation->set_rules('hexa', 'Couleur (code RGB hexadécimal)', 'max_length[10]|xss_clean');
	}
	
	private function _bungalow_set_rules()
	{
		$this->form_validation->set_rules('numero', 'Numero', 'required|max_length[50]|xss_clean');		
		$this->form_validation->set_rules('nom', 'Nom', 'max_length[50]|xss_clean');
		$this->form_validation->set_rules('capacite', 'Capacité', 'required|less_than[100]|is_numeric|intval');
		$this->form_validation->set_rules('equipe', 'Équipe', 'is_numeric|intval');
	}
}
