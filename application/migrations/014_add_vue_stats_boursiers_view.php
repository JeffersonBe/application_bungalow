

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 08/2012
*/

class Migration_Add_vue_stats_boursiers_view extends CI_Migration {

	public function up()
	{
		$this->db->query("
			CREATE VIEW `vue_stats_boursiers` AS select `compta`.`pallier` AS `pallier`,count(0) AS `nb`,(count(0) / (select count(0) from `compta`)) AS `pourcentage` from `compta` group by `compta`.`pallier`;
		");
	}

	public function down()
	{
		$this->db->query("
			DROP VIEW IF EXISTS `vue_stats_boursiers`
		");
	}
}