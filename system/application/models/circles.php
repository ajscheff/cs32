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
	
	function circleExists(){
		$this->db->select('username');
		$this->db->from('users');
		$this->db->where('username', $username);
		$query = $this->db->get();
		
		$row = $query->row_array();
		return !empty($row);
	}

}