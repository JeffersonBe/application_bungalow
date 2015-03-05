<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/

class Migration_Add_profil_table extends CI_Migration {

	public function up()
	{
		$this->db->query("
			--
			-- Structure de la table `profil`
			--

			CREATE TABLE IF NOT EXISTS `profil` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`adherent_id` int(11) unsigned NOT NULL,
			`disi` varchar(8) DEFAULT NULL,
			`email` varchar(100) DEFAULT NULL,
			`date_naissance` datetime DEFAULT NULL,
			`lieu_naissance` varchar(100) DEFAULT NULL,
			`portable` varchar(15) DEFAULT NULL,
			`fixe` varchar(15) DEFAULT NULL,
			`adresse` text,
			`fiche_rentree` tinyint(3) unsigned DEFAULT NULL,
			`regime` text,
			`modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			KEY `adherent_id` (`adherent_id`),
			KEY `disi` (`disi`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
	}

	public function down()
	{
		$this->dbforge->drop_table('profil');
	}
}