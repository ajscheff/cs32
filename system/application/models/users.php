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
	
	/**
	 * This method takes a username as a parameter
	 */
	function getUserID_username($username){
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('username', $username);
		$query = $this->db->get();
		
		$row = $query->row_array();
		if (empty($row)) return 0;
		else return $row['id'];
	}

	function getUserID_phone($phone_number){
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
    
	function createStubUser($phone_number, $provider_id)
	{
		$this->db->set('phone_number', $phone_number);
		$this->db->set('provider_id', $provider_id);
		$this->db->insert('users');
	}
	
	function createFullUser($username, $password, $phone_number, $provider_id, $public_name) {
		$this->db->set('username', $username);
		$this->db->set('password', $password);
		$this->db->set('phone_number', $phone_number);
		$this->db->set('provider_id', $provider_id);
		$this->db->set('public_name', $public_name);
		$this->db->insert('users');	
	}
}
