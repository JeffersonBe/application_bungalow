<?php

class Sei_model extends CI_Model {
	public $id;
	public $adherent_id;
	// Objet Adherent_model
	private $_adherent;
	public $bbq_sam;
	public $bbq_dim;
	public $bbq_lun;
	public $bbq_mar;
	public $bbq_mer;
	public $bbq_jeu;

	function __construct()
	{
		parent::__construct();
	}
}