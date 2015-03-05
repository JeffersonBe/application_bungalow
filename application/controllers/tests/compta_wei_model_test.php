<?php defined("BASEPATH") or exit("No direct script access allowed");
(defined("ENVIRONMENT") and (ENVIRONMENT == 'testing' or ENVIRONMENT == 'development'))
or exit("No tests running in production environment");

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Compta_wei_model_test extends CI_Controller {
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
		$this->load->model('Compta_wei_model');
		$this->load->library('unit_test');

		$adherent_id = $this->test_nouvel_adherent();
		$id_compta = $this->test_nouvelle_compta_wei($adherent_id);
		$this->test_supprimer_adherent($adherent_id);
		$this->test_verifier_suppression_compta_wei($id_compta);

		$adherent_id = $this->test_nouvel_adherent();
		$id_compta = $this->test_nouvelle_compta_wei($adherent_id);
		$compta = $this->test_charger_id_compta_wei(False, $adherent_id);
		$this->test_charger_adherent_id($adherent_id);
		$compta = $this->test_mettre_a_jour_compta_wei($compta);
		$this->test_supprimer_adherent($adherent_id);
		$this->test_verifier_suppression_compta_wei($id_compta);

		echo $this->unit->report();
	}

	public function test_nouvelle_compta_wei($adherent_id)
	{
		$compta = new $this->Compta_wei_model;
		$compta->adherent_id = $adherent_id;
		$compta->tarif_intitule = 'Tarif normal';
		$compta->prix = 250.;
		$compta->moyen_payement = 'cheque';
		$compta->caution = TRUE;
		$id_compta = $compta->enregistrer();

		$this->unit->run($id_compta, 'is_int', 'test_nouvelle_compta_wei is_int id');

		$compta = $this->Compta_wei_model->charger($id_compta);
		$this->unit->run($compta, 'is_object', 'test_nouvelle_compta_wei is_object charger');
		$this->unit->run($compta->adherent_id, $adherent_id, 'test_nouvelle_compta_wei adherent_id charger');
		$this->unit->run($compta->tarif_intitule, 'Tarif normal', 'test_nouvelle_compta_wei tarif_intitule charger');
		$this->unit->run($compta->prix, 250., 'test_nouvelle_compta_wei prix charger');
		$this->unit->run($compta->moyen_payement, 'cheque', 'test_nouvelle_compta_wei moyen_payement charger');
		$this->unit->run($compta->caution, TRUE, 'test_nouvelle_compta_wei caution charger');


		return $id_compta;
	}

	public function test_verifier_suppression_compta_wei($id_compta)
	{
		$compta = $this->Compta_wei_model->charger($id_compta);
		$this->unit->run($compta, FALSE, 'test_verifier_suppression_compta_wei FALSE charger');
	}

	public function test_charger_id_compta_wei($id_compta, $id_adherent)
	{
		$compta = $this->Compta_wei_model->charger($id_compta, $id_adherent);
		$this->unit->run($compta, 'is_object', 'test_charger_id_compta_wei is_object');
		if ($id_compta)
			$this->unit->run($compta->id, $id_compta, 'test_charger_id_compta_wei id compta');
		elseif ($id_adherent)
			$this->unit->run($compta->adherent_id, $id_adherent, 'test_charger_id_compta_wei id_adherent compta');
		return $compta;
	}

	public function test_charger_adherent_id($adherent_id)
	{
		$compta = $this->Compta_wei_model->charger(False, $adherent_id);
		$this->unit->run($compta, 'is_object', 'test_charger_adherent_id is_object');
		$this->unit->run($compta->adherent_id, $adherent_id, 'test_charger_adherent_id id adherent');
		return $compta;
	}

	public function test_mettre_a_jour_compta_wei($compta)
	{
		$compta->caution = FALSE;
		$compta->mettre_a_jour();

		$compta = $this->test_charger_id_compta_wei($compta->id, False);
		$this->unit->run($compta->caution, FALSE, 'test_mettre_a_jour_compta_wei caution');

		return $compta;
	}
}