<?php defined("BASEPATH") or exit("No direct script access allowed");
(defined("ENVIRONMENT") and (ENVIRONMENT == 'testing' or ENVIRONMENT == 'development'))
or exit("No tests running in production environment");

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/

class Compta_model_test extends CI_Controller {
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
		$this->load->model('Compta_model');
		$this->load->library('unit_test');

		$adherent_id = $this->test_nouvel_adherent();
		$id_compta = $this->test_nouvelle_compta($adherent_id);
		$this->test_supprimer_adherent($adherent_id);
		$this->test_verifier_suppression_compta($id_compta);

		$adherent_id1 = $this->test_nouvel_adherent();
		$id_compta1 = $this->test_nouvelle_compta($adherent_id1);
		$compta1 = $this->test_charger_id_compta($id_compta1);
		$this->test_charger_adherent_id($adherent_id1);
		$compta1 = $this->test_mettre_a_jour_compta($compta1);
		$adherent_id2 = $this->test_nouvel_adherent();
		$id_compta2 = $this->test_nouvelle_compta($adherent_id2);
		$compta2 = $this->test_charger_id_compta($id_compta2);
		$this->test_chercher_compta($adherent_id1, $adherent_id2, array('interet_sg' => 1));
		$this->test_supprimer_adherent($adherent_id1);
		$this->test_supprimer_adherent($adherent_id2);
		$this->test_verifier_suppression_compta($id_compta1);
		$this->test_verifier_suppression_compta($id_compta2);

		echo $this->unit->report();
	}

	public function test_nouvelle_compta($adherent_id)
	{
		$compta = new $this->Compta_model;
		$compta->adherent_id = $adherent_id;
		$compta->cotisant_bde = TRUE;
		$compta->moyen_payement_cotiz = 'cheque';
		$compta->interet_sg = FALSE;
		$compta->compte_sg = TRUE;
		$compta->rib = '00000 00000 00000000000 00';
		$compta->prelevement = TRUE;
		$compta->pallier = "Non boursier";
		$compta->tarif_intitule = "Plein tarif";
		$compta->prix = 250.50;
		$compta->etat_prelevement = 'prélevé';

		$id_compta = $compta->enregistrer();

		$this->unit->run($id_compta, 'is_int', 'test_nouvelle_compta is_int id');

		$chercher = $this->Compta_model->chercher(['id' => $id_compta]);
		$this->unit->run($chercher, 'is_array', 'test_nouvelle_compta is_array chercher');
		$this->unit->run(count($chercher), 1, 'test_nouvelle_compta taille chercher');
		$this->unit->run($chercher[0], 'is_int', 'test_nouvelle_compta is_int chercher[0]');

		return $id_compta;
	}

	public function test_verifier_suppression_compta($id_compta)
	{
		$chercher = $this->Compta_model->chercher(['id' => $id_compta]);
		$this->unit->run($chercher, 'is_array', 'test_nouvelle_compta is_array chercher');
		$this->unit->run(count($chercher), 0, 'test_nouvelle_compta taille chercher');
	}

	public function test_charger_id_compta($id_compta)
	{
		$compta = $this->Compta_model->charger($id_compta);
		$this->unit->run($compta, 'is_object', 'test_charger_id_compta is_object');
		$this->unit->run($compta->id, $id_compta, 'test_charger_id_compta id compta');
		return $compta;
	}

	public function test_charger_adherent_id($adherent_id)
	{
		$compta = $this->Compta_model->charger(False, $adherent_id);
		$this->unit->run($compta, 'is_object', 'test_charger_adherent_id is_object');
		$this->unit->run($compta->adherent_id, $adherent_id, 'test_charger_adherent_id id adherent');
		return $compta;
	}

	public function test_mettre_a_jour_compta($compta)
	{
		$compta->interet_sg = TRUE;
		$compta->mettre_a_jour();

		$compta = $this->test_charger_id_compta($compta->id);
		$this->unit->run($compta->interet_sg, TRUE, 'test_mettre_a_jour_compta interet_sg');

		return $compta;
	}

	public function test_chercher_compta($adherent_id1, $adherent_id2, $contraintes)
	{
		$adherents = $this->Compta_model->chercher(array());
		$this->unit->run($adherents, 'is_array', 'test_chercher_compta vide is_array');
		$adherents = $this->Compta_model->chercher(array('etat_prelevement' => 'prélevé'));
		$this->unit->run($adherents, 'is_array', 'test_chercher_compta cotisant_bde is_array');
		$this->unit->run(count($adherents), 2, 'test_chercher_compta cotisant_bde count');
		$adherents = $this->Compta_model->chercher($contraintes);
		$this->unit->run($adherents, 'is_array', 'test_chercher_compta interet_sg is_array');
		$this->unit->run(count($adherents), 1, 'test_chercher_compta interet_sg count');
		$this->unit->run($adherents[0], $adherent_id1, 'test_chercher_compta interet_sg id');
	}
}