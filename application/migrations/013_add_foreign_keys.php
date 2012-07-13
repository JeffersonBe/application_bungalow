<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/

class Migration_Add_foreign_keys extends CI_Migration {

	public function up()
	{
		$this->db->query("
			ALTER TABLE `compta`
			ADD CONSTRAINT `compta_ibfk_2` FOREIGN KEY (`adherent_id`) REFERENCES `adherent` (`id`) ON DELETE CASCADE;
		");

		$this->db->query("
			ALTER TABLE `compta_sei`
			ADD CONSTRAINT `compta_sei_ibfk_1` FOREIGN KEY (`adherent_id`) REFERENCES `adherent` (`id`) ON DELETE CASCADE;
		");

		$this->db->query("
			ALTER TABLE `compta_wei`
			ADD CONSTRAINT `compta_wei_ibfk_1` FOREIGN KEY (`adherent_id`) REFERENCES `adherent` (`id`) ON DELETE CASCADE;
		");

		$this->db->query("
			ALTER TABLE `profil`
			ADD CONSTRAINT `profil_ibfk_1` FOREIGN KEY (`adherent_id`) REFERENCES `adherent` (`id`) ON DELETE CASCADE;
		");

		$this->db->query("
			ALTER TABLE `sei`
			ADD CONSTRAINT `sei_ibfk_1` FOREIGN KEY (`adherent_id`) REFERENCES `adherent` (`id`) ON DELETE CASCADE;
		");

		$this->db->query("
			ALTER TABLE `wei_bungalow`
			ADD CONSTRAINT `wei_bungalow_ibfk_1` FOREIGN KEY (`equipe_id`) REFERENCES `wei_equipe` (`id`) ON DELETE SET NULL;
		");

		$this->db->query("
			ALTER TABLE `wei`
			ADD CONSTRAINT `wei_ibfk_1` FOREIGN KEY (`adherent_id`) REFERENCES `adherent` (`id`) ON DELETE CASCADE,
			ADD CONSTRAINT `wei_ibfk_2` FOREIGN KEY (`bungalow_id`) REFERENCES `wei_bungalow` (`id`) ON DELETE SET NULL,
			ADD CONSTRAINT `wei_ibfk_3` FOREIGN KEY (`equipe_id`) REFERENCES `wei_equipe` (`id`) ON DELETE SET NULL;
		");
	}

	public function down()
	{
		$this->db->query("
			ALTER TABLE `compta` DROP FOREIGN KEY `compta_ibfk_2`;
		");

		$this->db->query("
			ALTER TABLE `compta_sei` DROP FOREIGN KEY `compta_sei_ibfk_1`;
		");

		$this->db->query("
			ALTER TABLE `compta_wei` DROP FOREIGN KEY `compta_wei_ibfk_1`;
		");

		$this->db->query("
			ALTER TABLE `profil` DROP FOREIGN KEY `profil_ibfk_1`;
		");

		$this->db->query("
			ALTER TABLE `sei` DROP FOREIGN KEY `sei_ibfk_1`;
		");

		$this->db->query("
			ALTER TABLE `wei_bungalow` DROP FOREIGN KEY `wei_bungalow_ibfk_1`;
		");

		$this->db->query("
			ALTER TABLE `wei` DROP FOREIGN KEY `wei_ibfk_1`;
		");
		$this->db->query("
			ALTER TABLE `wei` DROP FOREIGN KEY `wei_ibfk_2`;
		");
		$this->db->query("
			ALTER TABLE `wei` DROP FOREIGN KEY `wei_ibfk_3`;
		");
	}
}