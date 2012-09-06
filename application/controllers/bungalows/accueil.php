<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Accueil extends CI_Controller {
	public function index()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Wei_bungalow_model');
		$this->load->model('Wei_equipe_model');
		$this->load->model('Wei_model');	
		$this->load->model('Profil_model');
		$this->load->model('Adherent_model');
		
		$this->form_validation->set_rules('email', 'Adresse e-mail', 'required|xss_clean');
		$this->form_validation->set_rules('pass', 'Mot de passe', 'required|xss_clean|callback_pass_check');
		
		$this->form_validation->set_error_delimiters('<div class="alert-box alert">', '<a href="" class="close">&times;</a></div>');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('bungalow/connection');
		}
		else {
			$profils = $this->Profil_model->chercher(array('email' => $this->input->post('email')));
			$profil = $this->Profil_model->charger(False, $profils[0]);
			$adherent = $this->Adherent_model->charger($profil->adherent_id);
			$staff = $adherent->promo != '2015' ? TRUE : FALSE;
			$newdata = array(
			                   'staff'  => $staff,
			                   'id'     => $adherent->id,
			               );
			$view_data = $newdata;
			
			if ($staff)
				$view_data['bungalows'] = $this->Wei_bungalow_model->chercher(array(), 0, 0, array('equipe_id' => 1));
			else
				$view_data['bungalows'] = $this->Wei_bungalow_model->chercher(array(), 0, 0, array('equipe_id !=' => 1));

			$bungalows = array();
			foreach($view_data['bungalows'] as $bungalow_id)
			{
				$bungalow = $this->Wei_bungalow_model->charger($bungalow_id);
				$bungalow->membres = $bungalow->lister_membres(0);
				array_push($bungalows, $bungalow);
			}

			$view_data['bungalows'] = $bungalows;
			$view_data['wei'] = $this->Wei_model->charger(False, intval($this->session->userdata('id')));
				
			$this->session->set_userdata($newdata);
			
			$this->load->view('bungalow/reserver', $view_data);
		}
	}
	
	public function reserver()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Wei_bungalow_model');
		$this->load->model('Wei_equipe_model');
		$this->load->model('Wei_model');
		$this->load->model('Profil_model');
		$this->load->model('Adherent_model');
		
		$staff = $this->session->userdata('staff');
		
		$view_data = array();
		
		if ($staff)
			$view_data['bungalows'] = $this->Wei_bungalow_model->chercher(array(), 0, 0, array('equipe_id' => 1));
		else
			$view_data['bungalows'] = $this->Wei_bungalow_model->chercher(array(), 0, 0, array('equipe_id !=' => 1));

		$bungalows = array();
		foreach($view_data['bungalows'] as $bungalow_id)
		{
			$bungalow = $this->Wei_bungalow_model->charger($bungalow_id);
			$bungalow->membres = $bungalow->lister_membres(0);
			array_push($bungalows, $bungalow);
		}

		$view_data['bungalows'] = $bungalows;
		$view_data['wei'] = $this->Wei_model->charger(False, $this->session->userdata('id'));
			
		$this->form_validation->set_rules('bungalows', 'Bungalow', 'required|max_length[10]|is_numeric|intval|xss_clean|callback_staff_check');
		$bungalow = $this->Wei_bungalow_model->charger($this->input->post('bungalows'));
		if ($this->input->post('bungalows') && $bungalow && !$bungalow->lister_membres(0))
			$this->form_validation->set_rules('nom_bungalow_'.$this->input->post('bungalows'), 'Nom du bungalow', 'required|min_length[2]|max_length[40]|xss_clean');
		
		$this->form_validation->set_error_delimiters('<div class="alert-box alert">', '<a href="" class="close">&times;</a></div>');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('bungalow/reserver', $view_data);
		}
		else {
			$wei = $this->Wei_model->charger(False, $this->session->userdata('id'));
			$wei->bungalow_id = $this->input->post('bungalows');
			$wei->equipe_id = $bungalow->equipe_id;
			if ($this->input->post('nom_bungalow_'.$this->input->post('bungalows')) && count(intval($bungalow->lister_membres(0))) == 0)
			{
				$bungalow->nom = $this->input->post('nom_bungalow_'.$this->input->post('bungalows'));
				$bungalow->mettre_a_jour();
			}
			$wei->mettre_a_jour();
			
			echo "Votre bungalow a été réservé.";
		}
	}
	
	public function pass_check($str)
	{
		$this->load->model('Adherent_model');
		$this->load->model('Profil_model');
		$this->load->model('Wei_model');
		$this->load->model('Wei_equipe_model');
		$this->load->model('Wei_bungalow_model');

		$this->form_validation->set_message('pass_check', 'Mot de passe incorrect ou adresse e-mail incorrects');
		$profils = $this->Profil_model->chercher(array('email' => $this->input->post('email')));
		if (count($profils) < 1)
			return FALSE;
		$profil = $this->Profil_model->charger(False, $profils[0]);
		
		$wei = $this->Wei_model->charger(False, $profil->adherent_id);
		if ($wei->wei != TRUE || $wei->mdp != $str)
			return FALSE;
		
		return TRUE;
	}
	
	public function staff_check($str)
	{
		$this->load->model('Wei_bungalow_model');
		$this->load->model('Wei_equipe_model');
		$this->load->model('Wei_model');
		
		$this->form_validation->set_message('staff_check', 'fuck you!');
		$i = intval($str);
		
		$bungalow = $this->Wei_bungalow_model->charger($i);
		if (!$bungalow)
			return False;
		
		$staff = $this->session->userdata('staff');
		if (!(($staff && $bungalow->_equipe->id == 1) || (!$staff && $bungalow->_equipe->id != 1)))
			return FALSE;
		
		if ($bungalow->lister_membres(0) != FALSE && count($bungalow->lister_membres(0)) < $bungalow->capacite)
			return TRUE;
	}
	
	public function deconnecter()
	{
		redirect('bungalows/accueil');
	}
}