<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Affichage des statistiques
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Stats extends CI_Controller {
	public function index() 
	{
		$this->load->model('Stats_model');
		$this->load->model('Wei_model');

		$data_statistiques = array(
			"stats_wei" => $this->Wei_model->places_restantes_wei(),
			"stats_ecoles" => $this->Stats_model->voir_ecoles(),
			"stats_sexes" => $this->Stats_model->voir_sexes(),
			"stats_boursiers" => $this->Stats_model->voir_boursiers(),
		);

		$this->load->view('backend/header', array('titre' => 'Statistiques'));
		$this->load->view('backend/menu');
		$this->load->view('backend/statistiques', $data_statistiques);
		$this->load->view('backend/footer');
	}
}