<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

class Migration_Add_adherent_table extends CI_Migration {

	public function up()
	{
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `adherent` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`prenom` varchar(70) NOT NULL,
			`nom` varchar(70) NOT NULL,
			`ecole` varchar(3) NOT NULL,
			`sexe` varchar(1) NOT NULL,
			`promo` smallint(4) unsigned NOT NULL,
			`creation` datetime NOT NULL,
			`modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			KEY `prenom` (`prenom`,`nom`,`ecole`,`sexe`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
	}

	public function down()
	{
		$this->dbforge->drop_table('adherent');
	}
}