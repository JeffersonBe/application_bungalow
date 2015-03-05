<?php defined("BASEPATH") or exit("No direct script access allowed");
(defined("ENVIRONMENT") and (ENVIRONMENT == 'testing' or ENVIRONMENT == 'development'))
or exit("No tests running in production environment");

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Wei_model_test extends CI_Controller {
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

	public function test_nouveau_bungalow($equipe_id)
	{
		$bungalow = new $this->Wei_bungalow_model;
		$bungalow->equipe_id = $equipe_id;
		$bungalow->numero = '42';
		$bungalow->capacite = 8;
		$id_bungalow = $bungalow->enregistrer();

		$this->unit->run($id_bungalow, 'is_int', 'test_nouveau_bungalow is_int id');

		$bungalow = $this->Wei_bungalow_model->charger($id_bungalow);
		$this->unit->run($bungalow, 'is_object', 'test_nouveau_bungalow is_object charger');
		$this->unit->run($bungalow->equipe_id, $equipe_id, 'test_nouveau_bungalow equipe_id charger');
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
		$this->load->model('Wei_equipe_model');
		$this->load->model('Wei_bungalow_model');
		$this->load->model('Wei_model');
		$this->load->library('unit_test');

		$adherent_id = $this->test_nouvel_adherent();
		$equipe_id = $this->test_nouvelle_equipe();
		$id_bungalow = $this->test_nouveau_bungalow($equipe_id);
		$id_wei = $this->test_nouveau_wei($id_bungalow, $equipe_id, $adherent_id);
		$this->test_supprimer_adherent($adherent_id);
		$this->test_supprimer_equipe($equipe_id);
		$this->test_verifier_suppression_equipe_bungalow($id_bungalow);
		$this->test_verifier_suppression_wei($id_wei);

		$adherent_id1 = $this->test_nouvel_adherent();
		$adherent_id2 = $this->test_nouvel_adherent();
		$equipe_id = $this->test_nouvelle_equipe();
		$id_bungalow = $this->test_nouveau_bungalow($equipe_id);
		$id_wei1 = $this->test_nouveau_wei($id_bungalow, $equipe_id, $adherent_id1);
		$wei1 = $this->test_charger_id_wei($id_wei1);
		$id_wei2 = $this->test_nouveau_wei($id_bungalow, $equipe_id, $adherent_id2);
		$wei2 = $this->test_charger_id_wei($id_wei2);
		$wei1 = $this->test_mettre_a_jour_wei($wei1);
		$this->test_chercher_wei($adherent_id1, $adherent_id2, ['clef' => '1337']);
		$this->test_supprimer_adherent($adherent_id1);
		$this->test_supprimer_adherent($adherent_id2);
		$this->test_supprimer_equipe($equipe_id);
		$this->test_verifier_suppression_equipe_bungalow($id_bungalow);
		$this->test_verifier_suppression_wei($id_wei1);
		$this->test_verifier_suppression_wei($id_wei2);

		echo $this->unit->report();
	}

	public function test_nouveau_wei($id_bungalow, $equipe_id, $adherent_id)
	{
		$wei = new $this->Wei_model;
		$wei->adherent_id = $adherent_id;
		$wei->interet = TRUE;
		$wei->wei = TRUE;
		$wei->clef = '42';
		$wei->etat_reservation = 1;
		$wei->bungalow_id = $id_bungalow;
		$wei->equipe_id = $equipe_id;
		$id_wei = $wei->enregistrer();

		$this->unit->run($id_wei, 'is_int', 'test_nouveau_wei is_int id');

		$wei = $this->Wei_model->charger($id_wei);
		$this->unit->run($wei, 'is_object', 'test_nouveau_wei is_object charger');
		$this->unit->run($wei->adherent_id, $adherent_id, 'test_nouveau_wei adherent_id charger');
		$this->unit->run($wei->interet, TRUE, 'test_nouveau_wei interet charger');
		$this->unit->run($wei->wei, TRUE, 'test_nouveau_wei wei charger');
		$this->unit->run($wei->clef, '42', 'test_nouveau_wei clef charger');
		$this->unit->run($wei->etat_reservation, 1, 'test_nouveau_wei etat_reservation charger');
		$this->unit->run($wei->bungalow_id, $id_bungalow, 'test_nouveau_wei id_bungalow charger');
		$this->unit->run($wei->equipe_id, $equipe_id, 'test_nouveau_wei equipe_id charger');

		return $id_wei;
	}

	public function test_verifier_suppression_wei($id_wei)
	{
		$wei = $this->Wei_model->charger($id_wei);
		$this->unit->run($wei, FALSE, 'test_verifier_suppression_wei supprimer');
	}

	public function test_charger_id_wei($id_wei)
	{
		$wei = $this->Wei_model->charger($id_wei);
		$this->unit->run($wei, 'is_object', 'test_charger_id_wei is_object');
		$this->unit->run($wei->id, $id_wei, 'test_charger_id_wei id');
		return $wei;
	}

	public function test_mettre_a_jour_wei($wei)
	{
		$wei->clef = '1337';
		$wei->mettre_a_jour();

		$wei = $this->test_charger_id_wei($wei->id);
		$this->unit->run($wei->clef, '1337', 'test_mettre_a_jour_wei numero');

		return $wei;
	}

	public function test_chercher_wei($adherent_id1, $adherent_id2, $contraintes)
	{
		$weis = $this->Wei_model->chercher(array());
		$this->unit->run($weis, 'is_array', 'test_chercher_wei vide is_array');
		$weis = $this->Wei_model->chercher($contraintes);
		$this->unit->run($weis, 'is_array', 'test_chercher_wei clef is_array');
		$this->unit->run(count($weis), 1, 'test_chercher_wei clef count');
		$this->unit->run($weis[0], $adherent_id1, 'test_chercher_bungalow clef id');
	}
}