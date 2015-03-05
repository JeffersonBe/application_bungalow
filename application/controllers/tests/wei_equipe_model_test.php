<?php defined("BASEPATH") or exit("No direct script access allowed");
(defined("ENVIRONMENT") and (ENVIRONMENT == 'testing' or ENVIRONMENT == 'development'))
or exit("No tests running in production environment");

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Wei_equipe_model_test extends CI_Controller {
	public function index()
	{
		$this->load->model('Wei_equipe_model');
		$this->load->library('unit_test');

		$equipe_id = $this->test_nouvelle_equipe();
		$this->test_supprimer_equipe($equipe_id);

		$equipe_id1 = $this->test_nouvelle_equipe();
		$equipe1 = $this->test_charger_id_equipe($equipe_id1);
		$equipe_id2 = $this->test_nouvelle_equipe();
		$equipe2 = $this->test_charger_id_equipe($equipe_id2);
		$equipe1 = $this->test_mettre_a_jour_equipe($equipe1);
		$this->test_chercher_equipe($equipe_id1, $equipe_id2, ['nom' => 'tata']);
		$this->test_lister_equipe();
		$this->test_supprimer_equipe($equipe_id1);
		$this->test_supprimer_equipe($equipe_id2);

		echo $this->unit->report();
	}

	public function test_nouvelle_equipe()
	{
		$equipe = new $this->Wei_equipe_model;
		$equipe->nom = 'tata';
		$id_equipe = $equipe->enregistrer();

		$this->unit->run($id_equipe, 'is_int', 'test_nouvelle_equipe is_int id');

		$equipe = $this->Wei_equipe_model->charger($id_equipe);
		$this->unit->run($equipe, 'is_object', 'test_nouvelle_equipe is_object charger');
		$this->unit->run($equipe->nom, 'tata', 'test_nouvelle_equipe nom charger');

		return $id_equipe;
	}

	public function test_supprimer_equipe($id_equipe)
	{
		$equipe = $this->test_charger_id_equipe($id_equipe);
		$equipe->supprimer();
		$equipe = $this->Wei_equipe_model->charger($id_equipe);
		$this->unit->run($equipe, FALSE, 'test_supprimer_equipe FALSE charger');
	}

	public function test_charger_id_equipe($id_equipe)
	{
		$equipe = $this->Wei_equipe_model->charger($id_equipe);
		$this->unit->run($equipe, 'is_object', 'test_charmode_payementger_id_equipe is_object');
		$this->unit->run($equipe->id, $id_equipe, 'test_charger_id_equipe id equipe');
		return $equipe;
	}

	public function test_mettre_a_jour_equipe($equipe)
	{
		$equipe->nom = 'toto';
		$equipe->mettre_a_jour();

		$equipe = $this->test_charger_id_equipe($equipe->id);
		$this->unit->run($equipe->nom, 'toto', 'test_mettre_a_jour_equipe nom');

		return $equipe;
	}

	public function test_chercher_equipe($equipe_id1, $equipe_id2, $contraintes)
	{
		$equipes = $this->Wei_equipe_model->chercher(array());
		$this->unit->run($equipes, 'is_array', 'test_chercher_equipe vide is_array');
		$equipes = $this->Wei_equipe_model->chercher($contraintes);
		$this->unit->run($equipes, 'is_array', 'test_chercher_equipe nom is_array');
		$this->unit->run(count($equipes), 1, 'test_chercher_equipe nom count');
		$this->unit->run($equipes[0], $equipe_id2, 'test_chercher_equipe nom id');
	}

	public function test_lister_equipe()
	{
		$equipes = $this->Wei_equipe_model->lister();
		$this->unit->run($equipes, 'is_array', 'test_lister_equipe is_array');
		$this->unit->run(count($equipes),  2, 'test_lister_equipe count');
		$this->unit->run($equipes[1], 'is_object', 'test_lister_equipe is_object1');
		$this->unit->run($equipes[1]->nom, 'toto', 'test_lister_equipe nom1 toto');
		$this->unit->run($equipes[0], 'is_object', 'test_lister_equipe is_object2');
		$this->unit->run($equipes[0]->nom, 'tata', 'test_lister_equipe nom2 tata');
	}
}