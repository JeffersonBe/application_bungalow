<?php defined("BASEPATH") or exit("No direct script access allowed");
(defined("ENVIRONMENT") and (ENVIRONMENT == 'testing' or ENVIRONMENT == 'development'))
or exit("No tests running in production environment");

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Wei_bungalow_model_test extends CI_Controller {
	public function test_nouvelle_equipe()
	{
		$equipe = new $this->Wei_equipe_model();
		$equipe->nom = 'tata';
		$id_equipe = $equipe->enregistrer();

		$this->unit->run($id_equipe, 'is_int', 'test_nouvelle_equipe is_int id');

		$equipe = $this->Wei_equipe_model->charger($id_equipe);
		$this->unit->run($equipe, 'is_object', 'test_nouvelle_equipe is_object charger');
		$this->unit->run($equipe->nom, 'tata', 'test_nouvelle_equipe nom charger');

		return $id_equipe;
	}

	public function test_charger_id_equipe($id_equipe)
	{
		$equipe = $this->Wei_equipe_model->charger($id_equipe);
		$this->unit->run($equipe, 'is_object', 'test_charmode_payementger_id_equipe is_object');
		$this->unit->run($equipe->id, $id_equipe, 'test_charger_id_equipe id equipe');
		return $equipe;
	}

	public function test_supprimer_equipe($id_equipe)
	{
		$equipe = $this->test_charger_id_equipe($id_equipe);
		$equipe->supprimer();
		$equipe = $this->Wei_equipe_model->charger($id_equipe);
		$this->unit->run($equipe, FALSE, 'test_supprimer_equipe FALSE charger');
	}

	public function index()
	{
		$this->load->model('Wei_equipe_model');
		$this->load->model('Wei_bungalow_model');
		$this->load->library('unit_test');

		$equipe_id = $this->test_nouvelle_equipe();
		$id_bungalow = $this->test_nouveau_bungalow($equipe_id);
		$this->test_supprimer_equipe($equipe_id);
		$this->test_verifier_suppression_equipe_bungalow($id_bungalow);

		$equipe_id = $this->test_nouvelle_equipe();
		$id_bungalow1 = $this->test_nouveau_bungalow($equipe_id);
		$bungalow1 = $this->test_charger_id_bungalow($id_bungalow1);
		$id_bungalow2 = $this->test_nouveau_bungalow($equipe_id);
		$bungalow2 = $this->test_charger_id_bungalow($id_bungalow2);
		$bungalow1 = $this->test_mettre_a_jour_bungalow($bungalow1);
		$this->test_chercher_bungalow($id_bungalow1, $id_bungalow2, ['numero' => '1337']);
		$this->test_lister_bungalows();
		$this->test_supprimer_equipe($equipe_id);
		$this->test_verifier_suppression_equipe_bungalow($id_bungalow1);
		$this->test_verifier_suppression_equipe_bungalow($id_bungalow2);

		echo $this->unit->report();
	}

	public function test_nouveau_bungalow($equipe_id)
	{
		$bungalow = new $this->Wei_bungalow_model;
		$bungalow->equipe_id = $equipe_id;
		$bungalow->nom = 'plop';
		$bungalow->numero = '42';
		$bungalow->capacite = 8;
		$id_bungalow = $bungalow->enregistrer();

		$this->unit->run($id_bungalow, 'is_int', 'test_nouveau_bungalow is_int id');

		$bungalow = $this->Wei_bungalow_model->charger($id_bungalow);
		$this->unit->run($bungalow, 'is_object', 'test_nouveau_bungalow is_object charger');
		$this->unit->run($bungalow->equipe_id, $equipe_id, 'test_nouveau_bungalow equipe_id charger');
		$this->unit->run($bungalow->numero, 'plop', 'test_nouveau_bungalow nom charger');
		$this->unit->run($bungalow->numero, '42', 'test_nouveau_bungalow numero charger');
		$this->unit->run($bungalow->capacite, 8, 'test_nouveau_bungalow capacite charger');

		return $id_bungalow;
	}

	public function test_verifier_suppression_equipe_bungalow($id_bungalow)
	{
		$bungalow = $this->test_charger_id_bungalow($id_bungalow);
		$this->unit->run($bungalow->equipe_id, NULL, 'test_verifier_suppression_equipe_bungalow SET NULL');
		$bungalow->supprimer();
		$bungalow = $this->Wei_bungalow_model->charger($id_bungalow);
		$this->unit->run($bungalow, FALSE, 'test_verifier_suppression_equipe_bungalow supprimer');
	}

	public function test_charger_id_bungalow($id_bungalow)
	{
		$bungalow = $this->Wei_bungalow_model->charger($id_bungalow);
		$this->unit->run($bungalow, 'is_object', 'test_charger_id_bungalow is_object');
		$this->unit->run($bungalow->id, $id_bungalow, 'test_charger_id_bungalow id');
		return $bungalow;
	}

	public function test_mettre_a_jour_bungalow($bungalow)
	{
		$bungalow->numero = '1337';
		$bungalow->mettre_a_jour();

		$bungalow = $this->test_charger_id_bungalow($bungalow->id);
		$this->unit->run($bungalow->numero, '1337', 'test_mettre_a_jour_bungalow numero');

		return $bungalow;
	}

	public function test_chercher_bungalow($bungalow_id1, $bungalow_id2, $contraintes)
	{
		$bungalows = $this->Wei_bungalow_model->chercher(array());
		$this->unit->run($bungalows, 'is_array', 'test_chercher_bungalow vide is_array');
		$bungalows = $this->Wei_bungalow_model->chercher($contraintes);
		$this->unit->run($bungalows, 'is_array', 'test_chercher_bungalow numero is_array');
		$this->unit->run(count($bungalows), 1, 'test_chercher_bungalow numero count');
		$this->unit->run($bungalows[0], $bungalow_id1, 'test_chercher_bungalow numero id');
	}

	public function test_lister_bungalows()
	{
		$bungalows = $this->Wei_bungalow_model->lister();
		$this->unit->run($bungalows, 'is_array', 'test_lister_bungalow is_array');
		$this->unit->run(count($bungalows),  2, 'test_lister_bungalow count');
		$this->unit->run($bungalows[1], 'is_object', 'test_lister_bungalow is_object1');
		$this->unit->run($bungalows[1]->numero, '1337', 'test_lister_bungalow numero1 1337');
		$this->unit->run($bungalows[0], 'is_object', 'test_lister_bungalow is_object2');
		$this->unit->run($bungalows[0]->numero, '42', 'test_lister_bungalow numero2 42');
	}
}