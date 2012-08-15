<?php defined("BASEPATH") or exit("No direct script access allowed");
(defined("ENVIRONMENT") and (ENVIRONMENT == 'testing' or ENVIRONMENT == 'development'))
or exit("No tests running in production environment");

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/

class Compta_sei_model_test extends CI_Controller {
	public function test_nouvel_adherent()
	{
		$adherent = new $this->Adherent_model();
		$adherent->prenom = "John";
		$adherent->nom = "Doe";
		$adherent->ecole = "tsp";
		$adherent->sexe = "m";
		$adherent->promo = 2015;
		$id = $adherent->enregistrer();
		$this->unit->run($id, 'is_int', 'test_nouvel_adherent id');
		return $id;
	}

	public function test_supprimer_adherent($id)
	{
		$adherent = $this->Adherent_model->charger($id);
		$this->unit->run($adherent, 'is_object', 'test_supprimer_adherent charger');
		$adherent->supprimer($id);
		$this->unit->run('', '', 'test_supprimer_adherent checkpoint');
	}

	public function index()
	{
		$this->load->model('Adherent_model');
		$this->load->model('Compta_sei_model');
		$this->load->library('unit_test');

		$adherent_id = $this->test_nouvel_adherent();
		$id_compta = $this->test_nouvelle_compta_sei($adherent_id);
		$this->test_supprimer_adherent($adherent_id);
		$this->test_verifier_suppression_compta_sei($id_compta);

		$adherent_id = $this->test_nouvel_adherent();
		$id_compta = $this->test_nouvelle_compta_sei($adherent_id);
		$compta = $this->test_charger_id_compta_sei(False, $adherent_id);
		$this->test_charger_adherent_id($adherent_id);
		$compta = $this->test_mettre_a_jour_compta_sei($compta);
		$this->test_supprimer_adherent($adherent_id);
		$this->test_verifier_suppression_compta_sei($id_compta);

		echo $this->unit->report();
	}

	public function test_nouvelle_compta_sei($adherent_id)
	{
		$compta = new $this->Compta_sei_model;
		$compta->adherent_id = $adherent_id;
		$compta->mode_payement = 'cheque';
		$compta->bbq_paye = TRUE;
		$compta->prix_paye = 5.;
		$id_compta = $compta->enregistrer();

		$this->unit->run($id_compta, 'is_int', 'test_nouvelle_compta_sei is_int id');

		$compta = $this->Compta_sei_model->charger($id_compta);
		$this->unit->run($compta, 'is_object', 'test_nouvelle_compta_sei is_object charger');
		$this->unit->run($compta->adherent_id, $adherent_id, 'test_nouvelle_compta_sei adherent_id charger');
		$this->unit->run($compta->mode_payement, 'cheque', 'test_nouvelle_compta_sei mode_payement charger');
		$this->unit->run($compta->bbq_paye, TRUE, 'test_nouvelle_compta_sei bbq_paye charger');
		$this->unit->run($compta->prix_paye, 5., 'test_nouvelle_compta_sei prix_paye charger');

		return $id_compta;
	}

	public function test_verifier_suppression_compta_sei($id_compta)
	{
		$compta = $this->Compta_sei_model->charger($id_compta);
		$this->unit->run($compta, FALSE, 'test_verifier_suppression_compta_sei FALSE charger');
	}

	public function test_charger_id_compta_sei($id_compta, $id_adherent)
	{
		$compta = $this->Compta_sei_model->charger($id_compta, $id_adherent);
		$this->unit->run($compta, 'is_object', 'test_charger_id_compta_sei is_object');
		if ($id_compta)
			$this->unit->run($compta->id, $id_compta, 'test_charger_id_compta_sei id compta');
		elseif ($id_adherent)
			$this->unit->run($compta->adherent_id, $id_adherent, 'test_charger_id_compta_sei id_adherent compta');
		return $compta;
	}

	public function test_charger_adherent_id($adherent_id)
	{
		$compta = $this->Compta_sei_model->charger(False, $adherent_id);
		$this->unit->run($compta, 'is_object', 'test_charger_adherent_id is_object');
		$this->unit->run($compta->adherent_id, $adherent_id, 'test_charger_adherent_id id adherent');
		return $compta;
	}

	public function test_mettre_a_jour_compta_sei($compta)
	{
		$compta->mode_payement = 'liquide';
		$compta->mettre_a_jour();

		$compta = $this->test_charger_id_compta_sei($compta->id, False);
		$this->unit->run($compta->mode_payement, 'liquide', 'test_mettre_a_jour_compta_sei mode_payement');

		return $compta;
	}
}