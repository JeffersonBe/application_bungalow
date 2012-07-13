<?php

class Wei_bungalow_model extends CI_Model {
	public $id;
	public $equipe_id;
	// objet Equipe_model
	private $_equipe;
	public $numero;
	public $capacite;
	
	function __construct()
	{
		parent::__construct();
	}
}