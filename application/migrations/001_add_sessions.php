<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/

class Migration_Add_sessions extends CI_Migration {

	public function up()
	{
		$this->db->query("
			CREATE TABLE IF NOT EXISTS  `ci_sessions` (
				session_id varchar(40) DEFAULT '0' NOT NULL,
				ip_address varchar(45) DEFAULT '0' NOT NULL,
				user_agent varchar(120) NOT NULL,
				last_activity int(10) unsigned DEFAULT 0 NOT NULL,
				user_data text NOT NULL,
				PRIMARY KEY (session_id),
				KEY `last_activity_idx` (`last_activity`)
			);
		");
	}

	public function down()
	{
		$this->dbforge->drop_table('ci_sessions');
	}
}