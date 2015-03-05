<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/

class Migration_Add_sei_table extends CI_Migration {

	public function up()
	{
		$this->db->query("
			--
			-- Structure de la table `sei`
			--

			CREATE TABLE IF NOT EXISTS `sei` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`adherent_id` int(11) unsigned NOT NULL,
			`bbq_sam` tinyint(1) DEFAULT NULL,
			`bbq_dim` tinyint(1) DEFAULT NULL,
			`bbq_lun` tinyint(1) DEFAULT NULL,
			`bbq_mar` tinyint(1) DEFAULT NULL,
			`bbq_mer` tinyint(1) DEFAULT NULL,
			`bbq_jeu` tinyint(1) DEFAULT NULL,
			`modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			KEY `adherent_id` (`adherent_id`,`bbq_sam`,`bbq_dim`,`bbq_lun`,`bbq_mar`,`bbq_mer`,`bbq_jeu`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
	}

	public function down()
	{
		$this->dbforge->drop_table('sei');
	}
}