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
		$this->load->view('backend/header', array('titre' => 'WEI'));
		$this->load->view('backend/menu');
		$this->load->view('backend/wei');
		$this->load->view('backend/footer');
	}
}