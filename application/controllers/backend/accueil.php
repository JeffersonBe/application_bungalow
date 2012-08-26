<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Page d'accueil du backend
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Accueil extends CI_Controller {
	public function index()
	{
		$this->load->helper('form');
		$this->load->model('Stats_model');
		$this->load->model('Wei_model');

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
}