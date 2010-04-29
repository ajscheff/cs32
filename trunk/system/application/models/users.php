<?php

class Users extends Model {

	var $title   = '';
	var $content = '';
	var $date    = '';

	function Users()
	{
		// Call the Model constructor
		parent::Model();
		$this->load->database();
	}
	
	function getUserID_username($username){
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('username', $username);
		$query = $this->db->get();
		
		$row = $query->row_array();
		if (empty($row)) return 0;
		else return $row['id'];
	}

	function getUserID_phone($phoneNumber){
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('phone_number', $phoneNumber);
		$query = $this->db->get();
		
		$row = $query->row_array();
		if (empty($row)) return 0;
		else return $row['id'];
	}
	
	function passwordMatches($username, $password){
		$this->db->select('password');
		$this->db->from('users');
		$this->db->where('username', $username);
		$query = $this->db->get();
		
		$row = $query->row_array();
		if(sizeof($row) == 1)
			return ($password == $row['password']);
		else return false;
	}
    
	function createUser($username, $password)
	{
		$this->db->set('username', $username);
		$this->db->set('password', $password);
		$this->db->insert('users');
	}
}
