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
			$this->load->view('backend/equipe_supprimer', $equipe_supprimer_data);
			$this->load->view('backend/footer');
		}
		else
			die("Équipe inexistante");
	}
	
	private function _equipe_set_rules()
	{
		$this->form_validation->set_rules('nom', 'Nom', 'required|max_length[50]|xss_clean');
		$this->form_validation->set_rules('hexa', 'Couleur (code RGB hexadécimal)', 'max_length[10]|xss_clean');
	}
}
