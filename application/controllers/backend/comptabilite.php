<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Gestion de la comptabilité
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Comptabilite extends CI_Controller {

	public function index(){
		$this->load->view('backend/header', array('titre' => 'Comptabilité'));
		$this->load->view('backend/menu');
		$this->load->view('backend/footer');
	}
}