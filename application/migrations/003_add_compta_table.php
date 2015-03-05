<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->dbforge();

/**
* @author Anthony VEREZ (netantho@minet.net)
*         président de MiNET 2012-2013
* @see http://www.anthony-verez.fr
* @since 07/2012
*/

class Migration_Add_compta_table extends CI_Migration {

	public function up()
	{
		$this->db->query("
			--
			-- Structure de la table `compta`
			--

			CREATE TABLE IF NOT EXISTS `compta` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`adherent_id` int(11) unsigned NOT NULL,
			`cotisant_bde` tinyint(1) NOT NULL,
			`moyen_payement_cotiz` varchar(20) DEFAULT NULL,
			`interet_sg` tinyint(1) unsigned DEFAULT NULL,
			`compte_sg` tinyint(1) unsigned DEFAULT NULL,
			`rib` varchar(30) DEFAULT NULL,
			`prelevement` tinyint(1) unsigned DEFAULT NULL,
			`pallier` varchar(10) DEFAULT NULL,
			`tarif_intitule` varchar(30) DEFAULT NULL,
			`prix` float DEFAULT NULL,
			`etat_prelevement` text,
			`modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			KEY `moyen_payement_cotiz` (`moyen_payement_cotiz`,`compte_sg`),
			KEY `adherent_id` (`adherent_id`),
			KEY `compte_sg` (`compte_sg`),
			KEY `prelevement` (`prelevement`),
			KEY `pallier` (`pallier`),
			KEY `tarif_intitule` (`tarif_intitule`),
			KEY `cotisant_bde` (`cotisant_bde`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
	}

	public function down()
	{
		$this->dbforge->drop_table('compta');
	}
}