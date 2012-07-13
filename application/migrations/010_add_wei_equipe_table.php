<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/

class Migration_Add_wei_equipe_table extends CI_Migration {

	public function up()
	{
		$this->db->query("
			--
			-- Structure de la table `wei_equipe`
			--

			CREATE TABLE IF NOT EXISTS `wei_equipe` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`nom` varchar(50) NOT NULL,
			`modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
	}

	public function down()
	{
		$this->dbforge->drop_table('wei_equipe');
	}
}