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
	
	function getCircleID_email($email){
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

		$queryResults = $query->result();

		if (empty($queryResults)) return NULL;
		else return $queryResults[0]->privileges;
	}

	function getMembers($circle_id) {
		$this->db->select('users.phone_number, providers.gateway, users_circles.user_id');
		$this->db->from('users');
		$this->db->join('users_circles', 'users_circles.user_id = users.id');
		$this->db->join('providers', 'users.provider_id = providers.id');
		$this->db->where('users_circles.circle_id', $circle_id);

		$query = $this->db->get();
		return $query->result();
	}

	function getAdmins($circle_id) {
		$this->db->select('users.phone_number, providers.gateway, users_circles.user_id');
		$this->db->from('users');
		$this->db->join('users_circles', 'users_circles.user_id = users.id');
		$this->db->join('providers', 'users.provider_id = providers.id');
		$this->db->where('users_circles.circle_id', $circle_id);
		$this->db->where('users_circles.admin', 1);
		
		$query = $this->db->get();
		return $query->result();
	}	
	
	function isMember($user_id, $circle_id) {
		
		$this->db->select();
		$this->db->from('users_circles');
		$this->db->where('circle_id', $circle_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		
		$results = $query->result();
		
		return (!empty($results));
	}
}
