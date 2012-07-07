<?php defined("BASEPATH") or exit("No direct script access allowed");

class Migration extends CI_Controller {

	public function index($version = FALSE){
		if (ENVIRONMENT == 'development')
		{
			$this->load->library("migration");

			if (!$version)
			{
				$version = $this->migration->current();
			}

			if(!$this->migration->version($version))
			{
				show_error($this->migration->error_string());
			}

			echo "Migrations r&eacute;alis&eacute;es avec succ&egrave;s";
		}
		else
		{
			redirect('/', 'location', 404);
			die();
		}
	}
}