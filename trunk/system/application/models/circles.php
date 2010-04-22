<?php

class Cirlces extends Model {

	var $title   = '';
	var $content = '';
	var $date    = '';

	function Cirlces()
	{
		// Call the Model constructor
		parent::Model();
		$this->load->database();
	}
	
	function circleExists($email){
		$this->db->select('id');
		$this->db->from('circles');
		$this->db->where('email', $email);
		$query = $this->db->get();
		
		$row = $query->row_array();
		if (empty($row)) return 0;
		else return $row[0]['id'];
	}
}