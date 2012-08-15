<?php defined("BASEPATH") or exit("No direct script access allowed");
(defined("ENVIRONMENT") and (ENVIRONMENT == 'testing' or ENVIRONMENT == 'development'))
or exit("No tests running in production environment");

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/

class All_test extends CI_Controller {
	public function index()
	{
		$tests = array(
			'adherent_model_test.php' => 'Adherent_model_test',
			'compta_model_test.php' => 'Compta_model_test',
			'compta_sei_model_test.php' => 'Compta_sei_model_test',
			'compta_wei_model_test.php' => 'Compta_wei_model_test',
			'profil_model_test.php' => 'Profil_model_test',
		);

		foreach ($tests as $file => $model)
		{
			require_once($file);

			$objet = eval('return new '.$model.'();');
			$objet->index();
		}
	}
}