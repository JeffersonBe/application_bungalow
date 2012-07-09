<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

class Migration_Add_wei_bungalow_table extends CI_Migration {

	public function up()
	{
		$this->db->query("
			--
			-- Structure de la table `wei_bungalow`
			--

			CREATE TABLE IF NOT EXISTS `wei_bungalow` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`equipe_id` int(11) unsigned DEFAULT NULL,
			`numero` varchar(50) DEFAULT NULL,
			`nom` varchar(50) DEFAULT NULL,
			`capacite` tinyint(2) unsigned NOT NULL,
			`modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			KEY `equipe_id` (`equipe_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
	}

	public function down()
	{
		$this->dbforge->drop_table('wei_bungalow');
	}
}