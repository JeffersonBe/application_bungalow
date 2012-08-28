<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Page d'accueil du backend
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Accueil extends CI_Controller {
	public function index()
	{
		$this->load->helper('form');
		$this->load->model('Stats_model');
		$this->load->model('Wei_model');
		$this->load->model('Log_model');
		$this->load->model('Adherent_model');
		$this->load->model('Wei_bungalow_model');
		$this->load->model('Wei_equipe_model');

		$logs = $this->Log_model->charger_confondus(15);
		foreach($logs as $log)
		{
			if (isset($log->adherent_id))
			{
				$log->adherent = $this->Adherent_model->charger($log->adherent_id);
				$log->entite = $log->adherent->prenom." ".$log->adherent->nom;
				$log->consulter = "backend/adherent/voir/".$log->adherent_id;
				$log->modifier = "backend/adherent/modifier/".$log->adherent_id;
			}
			elseif ($log->table == "wei_bungalow")
			{
				$log->wei_bungalow = $this->Wei_bungalow_model->charger($log->id);
				$log->entite = $log->wei_bungalow->numero." ".$log->wei_bungalow->nom;
				$log->consulter = "backend/wei/bungalow/voir/".$log->id;
				$log->modifier = "backend/wei/bungalow/modifier".$log->id;
			}
			elseif ($log->table == "wei_equipe")
			{
				$log->wei_equipe = $this->Wei_equipe_model->charger($log->id);
				$log->entite = $log->wei_equipe->nom;
				$log->consulter = "backend/wei/equipe/voir/".$log->id;
				$log->modifier = "backend/wei/equipe/modifier/".$log->id;
			}
		}

		$data_accueil = array(
			"stats_wei" => $this->Wei_model->places_restantes_wei(),
			"stats_ecoles" => $this->Stats_model->voir_ecoles(),
			"stats_sexes" => $this->Stats_model->voir_sexes(),
			"logs" => $logs,
		);

		$this->load->view('backend/header', array('titre' => 'Accueil'));
		$this->load->view('backend/menu');
		$this->load->view('backend/accueil', $data_accueil);
		$this->load->view('backend/footer');
	}
}