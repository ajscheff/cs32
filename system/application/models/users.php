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
		
		$rows = $query->result();
		if (empty($rows)) return 0;
		else return $rows[0]->id;
	}

	function getUserID_phone($phone_number){
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('phone_number', $phone_number);
		$query = $this->db->get();
		
		$rows = $query->result();
		if (empty($rows)) return 0;
		else return $rows[0]->id;
	}
	
	function getUsername($user_id) {
		$this->db->select('username');
		$this->db->from('users');
		$this->db->where('users.id', $user_id);
		
		$query = $this->db->get();
		
		$rows = $query->result();
		if (empty($rows)) return NULL;
		else return $rows[0]->username;
	}
	
	function passwordMatches($username, $password){
		$this->db->select('password');
		$this->db->from('users');
		$this->db->where('username', $username);
		$query = $this->db->get();
		
		$rows = $query->result();
		if(sizeof($rows) == 1)
			return ($password == $rows[0]->password);
		else return false;
	}
    
	function createStubUser($phone_number, $provider_id)
	{
		$this->db->set('phone_number', $phone_number);
		$this->db->set('provider_id', $provider_id);
		$this->db->insert('users');
		
		return $this->getUserID_phone($phone_number);
	}
	
	function getProviderID($gateway) {
		
		$this->db->select('id');
		$this->db->from('providers');
		$this->db->where('gateway', $gateway);
		
		$query = $this->db->get();
		
		$rows = $query->result();
		if (empty($rows)) return 0;
		else return $rows[0]->id;
	}
	
	function addProvider($gateway) {
	
		$this->db->set('name', $gateway);
		$this->db->set('gateway', $gateway);
		$this->db->insert('providers');
		
		return $this->getProviderID($gateway);
	}
	
	function createFullUser($username, $password, $phone_number, $provider_id, $public_name) {
		$this->db->set('username', $username);
		$this->db->set('password', $password);
		$this->db->set('phone_number', $phone_number);
		$this->db->set('provider_id', $provider_id);
		$this->db->set('public_name', $public_name);
		$this->db->insert('users');	
		
		return $this->getUserID_username($username);
	}
}
