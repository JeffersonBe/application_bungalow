<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Lancement des invitation mails
*
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 09/2012
*/

class Launch extends CI_Controller {
	public function index()
	{
		$promo = '2015';
		
		$this->load->model('Adherent_model');
		$this->load->model('Profil_model');
		$this->load->model('Wei_model');
		$this->load->model('Wei_bungalow_model');
		$this->load->model('Wei_equipe_model');
		
		$liste = $this->Wei_model->chercher(array(), array('wei' => 1), 0);
		foreach($liste as $adherent_id)
		{
			var_dump($adherent_id);
			$adherent = $this->Adherent_model->charger($adherent_id);
			var_dump($adherent);
			if ($adherent)
			{
				$profil = $this->Profil_model->charger(False, $adherent_id);
				$wei = $this->Wei_model->charger(False, $adherent_id);
				if ($adherent->promo == $promo)
				{
					// Générer les mdp
					$wei->mdp = $wei->nouveau_pass();
					$wei->mettre_a_jour();
					if ($profil->email)
					{
						// Envoyer un mail
						$this->load->library('email');
						$this->email->from('contact@showtime2012.fr', 'BDE Showtime');
						$this->email->to($profil->email);
						$this->email->subject('Réservation des bungalows WEI');
						$this->email->message("L'application bungalow est ouverte !\nRDV sur http://showtime2012.fr/rentree/bungalows/accueil\nUtilisez cette adresse e-mail et le mot de passe ".$wei->mdp."\nEn cas de problème, envoyer un mail à contact@showtime2012.fr"); 
						$this->email->send();
						echo $this->email->print_debugger();
						echo $adherent->prenom." ".$adherent->nom." Réussi<br />";
					}
					else {
						echo $adherent->prenom." ".$adherent->nom." <b>n'a pas d'adresse e-mail !</b><br />";
					}
				}
			}
			else {
				echo "Erreur pour l'id ".$adherent_id."<br />";
			}
		}
	}
}