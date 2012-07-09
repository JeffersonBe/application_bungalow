<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

class Migration_Add_compta_wei_table extends CI_Migration {

	public function up()
	{
		$this->db->query("
			--
			-- Structure de la table `compta_wei`
			--

			CREATE TABLE IF NOT EXISTS `compta_wei` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`adherent_id` int(11) unsigned NOT NULL,
			`tarif_intitule` varchar(30) NOT NULL,
			`prix` float NOT NULL,
			`moyen_payement` varchar(20) NOT NULL,
			`caution` tinyint(1) unsigned NOT NULL,
			`modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			KEY `adherent_id` (`adherent_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
	}

	public function down()
	{
		$this->dbforge->drop_table('compta_wei');
	}
}