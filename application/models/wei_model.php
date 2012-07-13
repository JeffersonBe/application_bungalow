<?php

class Wei_model extends CI_Model {
	public $id;
	public $adherent_id;
	// objet Adherent_model
	private $_adherent;
	public $wei;
	public $clef;
	public $etat_reservation;
	public $bungalow_id;
	// objet Wei_bungalow_model
	private $_bungalow;
	public $equipe_id;
	// objet Wei_equipe_Model
	private $_equipe;
	
	function __construct()
	{
		parent::__construct();
	}
}