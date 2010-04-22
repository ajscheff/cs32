<?php

class Circles extends Model {

	var $title   = '';
	var $content = '';
	var $date    = '';

	function Circles(){
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
		else return $row['id'];
	}

	function getPermissions($user_id, $circle_id){
		$this->db->select('privileges');
		$this->db->from('users_circles');
		$this->db->where('user_id', $user_id);
		$this->db->where('circle_id', $circle_id);
		$query = $this->db->get();

		$row = $query->row_array();
		if (empty($row)) return NULL;
		else return $row['privileges'];
	}

	function getMemberEmails($circle_id) {
		$this->db->select('*');
		$this->db->from('users_circles');
		//$this->db->join('users', 'users_circles.user_id = users.id');
		//$this->db->join('providers', 'users.provider_id = providers.id', 'left');
		//$this->db->where('users_circles.circle_id', 1);

		$query = $this->db->get();

		$rows = $query->row_array();

		print_r($rows);
	}

	function getAdminEmails($circle_id) {

	}	
}