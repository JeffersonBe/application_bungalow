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
}
