<?php defined("BASEPATH") or exit("No direct script access allowed");
(defined("ENVIRONMENT") and (ENVIRONMENT == 'testing' or ENVIRONMENT == 'development'))
or exit("No tests running in production environment");

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/
class Adherent_model_test extends CI_Controller {
	public function index()
	{
		$this->load->model('Adherent_model');
		$this->load->library('unit_test');
		$this->unit->use_strict(TRUE);

		$id = $this->test_nouvel_adherent();
		$this->test_supprimer_adherent($id);

		$id1 = $this->test_nouvel_adherent();
		$this->test_mettre_a_jour_adherent($id1);
		$id2 = $this->test_nouvel_adherent();
		$this->test_lister_adherent($id1, $id2);
		$this->test_chercher_adherent($id1, $id2, array('prenom' => 'Johanna'));
		$this->test_supprimer_adherent($id1);
		$this->test_supprimer_adherent($id2);

		echo $this->unit->report();
	}

	private function test_nouvel_adherent()
	{
		$adherent = new $this->Adherent_model;
		$adherent->prenom = "John";
		$adherent->nom = "Doe";
		$adherent->ecole = "tsp";
		$adherent->sexe = "m";
		$adherent->promo = 2015;
		$id = $adherent->enregistrer();
		$this->unit->run($id, 'is_int', 'test_nouvel_adherent id');
		return $id;
	}

	private function test_supprimer_adherent($id)
	{
		$adherent = $this->Adherent_model->charger($id);
		$this->unit->run($adherent, 'is_object', 'test_supprimer_adherent charger');
		$adherent->supprimer($id);
		$this->unit->run('', '', 'test_supprimer_adherent checkpoint');
	}

	private function test_mettre_a_jour_adherent($id)
	{
		$adherent = $this->Adherent_model->charger($id);
		$this->unit->run($adherent, 'is_object', 'test_mettre_a_jour_adherent charger');
		$adherent->prenom = "Johanna";
		$adherent->mettre_a_jour();
		$adherent = $this->Adherent_model->charger($id);
		$this->unit->run($adherent->prenom, 'Johanna', 'test_mettre_a_jour_adherent changer prenom'); 
	}

	private function test_lister_adherent($id1, $id2)
	{
		$adherents = $this->Adherent_model->lister($limite=1);
		$this->unit->run($adherents, 'is_array', 'test_lister_adherent limite1, is_array');
		$this->unit->run(count($adherents), 1, 'test_lister_adherent limite1, count');
		$this->unit->run($adherents[0], 'is_object', 'test_lister_adherent limite1, objet');
		$this->unit->run($adherents[0]->id, $id2, 'test_lister_adherent limite1, id');
		$this->unit->run($adherents[0]->prenom, 'John', 'test_lister_adherent limite1, prenom');
		$adherents = $this->Adherent_model->lister($limite=2);
		$this->unit->run($adherents, 'is_array', 'test_lister_adherent limite2, is_array');
		$this->unit->run(count($adherents), 2, 'test_lister_adherent limite2, count');
		$this->unit->run($adherents[0], 'is_object', 'test_lister_adherent limite2, objet0');
		$this->unit->run($adherents[1], 'is_object', 'test_lister_adherent limite2, objet1');
		$this->unit->run($adherents[0]->id, $id2, 'test_lister_adherent limite2, id0');
		$this->unit->run($adherents[1]->id, $id1, 'test_lister_adherent limite2, id1');
		$this->unit->run($adherents[0]->prenom, 'John', 'test_lister_adherent limite2, prenom0');
		$this->unit->run($adherents[1]->prenom, 'Johanna', 'test_lister_adherent limite2, prenom1');
	}

	private function test_chercher_adherent($id1, $id2, $contraintes)
	{
		$adherents = $this->Adherent_model->chercher(array());
		$this->unit->run($adherents, 'is_array', 'test_chercher_adherent vide is_array');
		$this->unit->run($adherents, 'is_array', 'test_lister_adherent vide is_array');
		$adherents = $this->Adherent_model->chercher(array('nom' => 'Doe'));
		$this->unit->run($adherents, 'is_array', 'test_chercher_adherent Doe is_array');
		$this->unit->run($adherents, 'is_array', 'test_lister_adherent Doe is_array');
		$this->unit->run(count($adherents), 2, 'test_lister_adherent Doe count');
		$adherents = $this->Adherent_model->chercher($contraintes);
		$this->unit->run($adherents, 'is_array', 'test_chercher_adherent Johanna is_array');
		$this->unit->run(count($adherents), 1, 'test_lister_adherent Johanna count');
		$this->unit->run($adherents[0], $id1, 'test_lister_adherent Johanna id');
	}
}