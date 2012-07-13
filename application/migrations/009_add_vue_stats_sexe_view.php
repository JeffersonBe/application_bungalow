<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/

class Migration_Add_vue_stats_sexe_view extends CI_Migration {

	public function up()
	{
		$this->db->query("
			--
			-- Structure de la vue `vue_stats_sexe`
			--

			CREATE VIEW `vue_stats_sexe` AS select `adherent`.`sexe` AS `sexe`,count(0) AS `nb`,(count(0) / (select count(0) from `adherent`)) AS `pourcentage` from `adherent` group by `adherent`.`sexe`;
		");
	}

	public function down()
	{
		$this->db->query("
			DROP VIEW IF EXISTS `vue_stats_sexe`
		");
	}
}