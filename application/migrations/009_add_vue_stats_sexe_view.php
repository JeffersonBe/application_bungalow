<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

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