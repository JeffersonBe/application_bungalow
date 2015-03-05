<?php defined("BASEPATH") or exit("No direct script access allowed");
(defined("ENVIRONMENT") and (ENVIRONMENT == 'testing' or ENVIRONMENT == 'development'))
or exit("No tests running in production environment");

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Stats_model_test extends CI_Controller {
	public function index()
	{
		$this->load->model('Stats_model');
		$this->load->library('unit_test');

		$this->test_stats_voir_ecoles();
		$this->test_stats_voir_sexes();

		echo $this->unit->report();
	}

	public function test_stats_voir_ecoles()
	{
		$res = $this->Stats_model->voir_ecoles();
		if (count($res) != 0)
		{
			foreach ($res as $entree)
			{
				$this->unit->run($entree, 'is_object', 'test_stats_voir_ecoles is_object');
				$this->unit->run($entree->ecole, 'is_string', 'test_stats_voir_ecoles ecole');
				$this->unit->run($entree->nb, 'is_int', 'test_stats_voir_ecoles nb');
				$this->unit->run($entree->pourcentage, 'is_float', 'test_stats_voir_ecoles pourcentage');
			}
		}
	}

	public function test_stats_voir_sexes()
	{
		$res = $this->Stats_model->voir_sexes();
		if (count($res) != 0)
		{
			foreach ($res as $entree)
			{
				$this->unit->run($entree, 'is_object', 'test_stats_voir_sexes is_object');
				$this->unit->run($entree->sexe, 'is_string', 'test_stats_voir_sexes sexe');
				$this->unit->run($entree->nb, 'is_int', 'test_stats_voir_sexes nb');
				$this->unit->run($entree->pourcentage, 'is_float', 'test_stats_voir_sexes pourcentage');
			}
		}
	}
}