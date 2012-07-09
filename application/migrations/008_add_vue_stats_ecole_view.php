<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

class Migration_Add_vue_stats_ecole_view extends CI_Migration {

	public function up()
	{
		$this->db->query("
			--
			-- Structure de la vue `vue_stats_ecole`
			--

			CREATE VIEW `vue_stats_ecole` AS select `adherent`.`ecole` AS `ecole`,count(0) AS `nb`,(count(0) / (select count(0) from `adherent`)) AS `pourcentage` from `adherent` group by `adherent`.`ecole`;
		");
	}

	public function down()
	{
		$this->db->query("
			DROP VIEW IF EXISTS `vue_stats_ecole`
		");
	}
}