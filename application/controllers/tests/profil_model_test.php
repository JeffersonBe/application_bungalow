<?php defined("BASEPATH") or exit("No direct script access allowed");
(defined("ENVIRONMENT") and (ENVIRONMENT == 'testing' or ENVIRONMENT == 'development'))
or exit("No tests running in production environment");

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Profil_model_test extends CI_Controller {
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
		$this->load->model('Profil_model');
		$this->load->library('unit_test');

		$adherent_id = $this->test_nouvel_adherent();
		$id_compta = $this->test_nouveau_profil($adherent_id);
		$this->test_supprimer_adherent($adherent_id);
		$this->test_verifier_suppression_profil($id_compta);

		$adherent_id1 = $this->test_nouvel_adherent();
		$id_profil1 = $this->test_nouveau_profil($adherent_id1);
		$profil1 = $this->test_charger_id_profil($id_profil1, False);
		$profil1 = $this->test_mettre_a_jour_profil($profil1);
		$adherent_id2 = $this->test_nouvel_adherent();
		$id_profil2 = $this->test_nouveau_profil($adherent_id2);
		$profil2 = $this->test_charger_id_profil(False, $adherent_id2);
		$this->test_chercher_profil($adherent_id1, $adherent_id2, array('regime' => 'casher'));
		$this->test_supprimer_adherent($adherent_id1);
		$this->test_supprimer_adherent($adherent_id2);
		$this->test_verifier_suppression_profil($id_profil1);
		$this->test_verifier_suppression_profil($id_profil2);

		echo $this->unit->report();
	}

	public function test_nouveau_profil($adherent_id)
	{
		$profil = new $this->Profil_model;
		$profil->adherent_id = $adherent_id;
		$profil->disi = 'verez_an';
		$profil->email = 'verez_an@it-sudparis.eu';
		$profil->date_naissance = '2012-06-15 00:00:00';
		$profil->lieu_naissance = 'New York';
		$profil->portable = '+33600000000';
		$profil->fiche_rentree = 421;
		$profil->regime = 'Halal';

		$id_profil = $profil->enregistrer();

		$this->unit->run($id_profil, 'is_int', 'test_nouveau_profil is_int id');

		$chercher = $this->Profil_model->chercher(['id' => $id_profil]);
		$this->unit->run($chercher, 'is_array', 'test_nouveau_profil is_array chercher');
		$this->unit->run(count($chercher), 1, 'test_nouveau_profil taille chercher');
		$this->unit->run($chercher[0], 'is_int', 'test_nouveau_profil is_int chercher[0]');

		return $id_profil;
	}

	public function test_verifier_suppression_profil($id_profil)
	{
		$chercher = $this->Profil_model->chercher(['id' => $id_profil]);
		$this->unit->run($chercher, 'is_array', 'test_verifier_suppression_profil is_array chercher');
		$this->unit->run(count($chercher), 0, 'test_verifier_suppression_profil taille chercher');
	}

	public function test_charger_id_profil($id_profil, $id_adherent)
	{
		$profil = $this->Profil_model->charger($id_profil, $id_adherent);
		$this->unit->run($profil, 'is_object', 'test_charger_id_profil is_object');
		if ($id_profil)
			$this->unit->run($profil->id, $id_profil, 'test_charger_id_profil id profil');
		elseif ($id_adherent)
			$this->unit->run($profil->adherent_id, $id_adherent, 'test_charger_id_profil id_adherent profil');
		return $profil;
	}

	public function test_mettre_a_jour_profil($profil)
	{
		$profil->regime = 'casher';
		$profil->mettre_a_jour();

		$profil = $this->test_charger_id_profil($profil->id, False);
		$this->unit->run($profil->regime, 'casher', 'test_mettre_a_jour_profil regime');

		return $profil;
	}

	public function test_chercher_profil($adherent_id1, $adherent_id2, $contraintes)
	{
		$adherents = $this->Profil_model->chercher(array());
		$this->unit->run($adherents, 'is_array', 'test_chercher_profil vide is_array');
		$adherents = $this->Profil_model->chercher(array('lieu_naissance' => 'New York'));
		$this->unit->run($adherents, 'is_array', 'test_chercher_profil lieu_naissance is_array');
		$this->unit->run(count($adherents), 2, 'test_chercher_profil lieu_naissance count');
		$adherents = $this->Profil_model->chercher($contraintes);
		$this->unit->run($adherents, 'is_array', 'test_chercher_profil regime is_array');
		$this->unit->run(count($adherents), 1, 'test_chercher_profil regime count');
		$this->unit->run($adherents[0], $adherent_id1, 'test_chercher_profil regime id');
	}
}