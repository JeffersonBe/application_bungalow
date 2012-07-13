<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/

class Migration_Add_wei_table extends CI_Migration {

	public function up()
	{
		$this->db->query("
			--
			-- Structure de la table `wei`
			--

			CREATE TABLE IF NOT EXISTS `wei` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`adherent_id` int(11) unsigned NOT NULL,
			`interet` tinyint(1) unsigned DEFAULT NULL,
			`wei` tinyint(1) DEFAULT NULL,
			`clef` varchar(50) DEFAULT NULL,
			`etat_reservation` tinyint(1) DEFAULT NULL,
			`bungalow_id` int(11) unsigned DEFAULT NULL,
			`equipe_id` int(11) unsigned DEFAULT NULL,
			`modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			KEY `adherent_id` (`adherent_id`),
			KEY `bungalow_id` (`bungalow_id`),
			KEY `equipe_id` (`equipe_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
	}

	public function down()
	{
		$this->dbforge->drop_table('wei');
	}
}