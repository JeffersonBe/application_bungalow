<?php defined("BASEPATH") or exit("No direct script access allowed");
(defined("ENVIRONMENT") and (ENVIRONMENT == 'testing' or ENVIRONMENT == 'development'))
or exit("No tests running in production environment");

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Sei_model_test extends CI_Controller {
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

	public function index()
	{
		$this->load->model('Adherent_model');
		$this->load->model('Compta_sei_model');
		$this->load->model('Sei_model');
		$this->load->library('unit_test');

		$adherent_id = $this->test_nouvel_adherent();
		$id_sei = $this->test_nouvelle_sei($adherent_id);
		$this->test_supprimer_adherent($adherent_id);
		$this->test_verifier_suppression_sei($id_sei);

		$adherent_id1 = $this->test_nouvel_adherent();
		$id_sei1 = $this->test_nouvelle_sei($adherent_id1);
		$sei1 = $this->test_charger_id_sei($id_sei1, False);
		$sei1 = $this->test_mettre_a_jour_sei($sei1);
		$adherent_id2 = $this->test_nouvel_adherent();
		$id_sei2 = $this->test_nouvelle_sei($adherent_id2);
		$sei2 = $this->test_charger_id_sei(False, $adherent_id2);
		$this->test_nouvelle_compta_sei($adherent_id1);
		$this->test_nouvelle_compta_sei($adherent_id2);
		$this->test_qui_mange($adherent_id1, $adherent_id2);
		$this->test_supprimer_adherent($adherent_id1);
		$this->test_supprimer_adherent($adherent_id2);
		$this->test_verifier_suppression_sei($id_sei1);
		$this->test_verifier_suppression_sei($id_sei2);

		echo $this->unit->report();
	}

	public function test_nouvelle_sei($adherent_id)
	{
		$sei = new $this->Sei_model;
		$sei->adherent_id = $adherent_id;
		$sei->bbq_sam = FALSE;
		$sei->bbq_dim = TRUE;
		$sei->bbq_lun = TRUE;
		$sei->bbq_mar = TRUE;
		$sei->bbq_mer = FALSE;
		$sei->bbq_jeu = TRUE;
		$id_sei = $sei->enregistrer();

		$this->unit->run($id_sei, 'is_int', 'test_nouvelle_sei is_int id');

		$sei = $this->Sei_model->charger($id_sei);
		$this->unit->run($sei, 'is_object', 'test_nouvelle_sei is_object charger');
		$this->unit->run($sei->adherent_id, $adherent_id, 'test_nouvelle_sei adherent_id charger');
		$this->unit->run($sei->bbq_sam, FALSE, 'test_nouvelle_sei bbq_sam charger');
		$this->unit->run($sei->bbq_dim, TRUE, 'test_nouvelle_sei bbq_dim charger');
		$this->unit->run($sei->bbq_lun, TRUE, 'test_nouvelle_sei bbq_lun charger');
		$this->unit->run($sei->bbq_mar, TRUE, 'test_nouvelle_sei bbq_mar charger');
		$this->unit->run($sei->bbq_mer, FALSE, 'test_nouvelle_sei bbq_mer charger');
		$this->unit->run($sei->bbq_jeu, TRUE, 'test_nouvelle_sei bbq_jeu charger');

		return $id_sei;
	}

	public function test_verifier_suppression_sei($id_sei)
	{
		$sei = $this->Sei_model->charger($id_sei);
		$this->unit->run($sei, FALSE, 'test_verifier_suppression_sei FALSE charger');
	}

	public function test_charger_id_sei($id_sei, $id_adherent)
	{
		$sei = $this->Sei_model->charger($id_sei, $id_adherent);
		$this->unit->run($sei, 'is_object', 'test_charger_id_sei is_object');
		if ($id_sei)
			$this->unit->run($sei->id, $id_sei, 'test_charger_id_sei id sei');
		elseif ($id_adherent)
			$this->unit->run($sei->adherent_id, $id_adherent, 'test_charger_id_sei id_adherent sei');
		return $sei;
	}

	public function test_mettre_a_jour_sei($sei)
	{
		$sei->bbq_sam = TRUE;
		$sei->mettre_a_jour();

		$sei = $this->test_charger_id_sei($sei->id, FALSE);
		$this->unit->run($sei->bbq_sam, TRUE, 'test_mettre_a_jour_sei bbq_sam');

		return $sei;
	}

	public function test_qui_mange($id_adherent1, $id_adherent2)
	{
		$res = $this->Sei_model->qui_mange('sam');
		$this->unit->run($res, 'is_array', 'test_qui_mange is_array');
		$this->unit->run(count($res), 1, 'test_qui_mange count');
		$this->unit->run($res[0]->adherent_id, $id_adherent1, 'test_qui_mange adherent_id');
	}
}