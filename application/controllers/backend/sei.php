<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Gestion de la SEI
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Sei extends CI_Controller {
	public function index($jour='sam')
	{
		$this->load->model('Sei_model');
		$this->load->model('Adherent_model');
		$this->load->model('Compta_sei_model');
		$this->load->model('Profil_model');

		$adherents = $this->Sei_model->qui_mange($jour, 'adherent.nom', 'asc');

		$data_sei = array(
			"adherents" => $adherents,
			"jour" => $jour,
		);

		$this->load->view('backend/header', array('titre' => $jour.' SEI'));
		$this->load->view('backend/menu');
		$this->load->view('backend/sei', $data_sei);
		$this->load->view('backend/footer');
	}
}