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
	
	function usernameExists($username){
		$this->db->select('username');
		$this->db->from('users');
		$this->db->where('username', $username);
		$query = $this->db->get();
		
		$row = $query->row_array();
		return !empty($row);
	}
	
	function passwordMatches($username, $password){
		$this->db->select('password');
		$this->db->from('users');
		$this->db->where('username', $username);
		$query = $this->db->get();
		
		$row = $query->row_array();
		return ($password == $row['password']);
	}
    
	function createUser($username, $password)
	{
		$this->db->set('username', $username);
		$this->db->set('password', $password);
		$this->db->insert('users');
	}
		

}