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
	
	/**
	 * Returns the id of the circle with the passed email address. This method 
	 * expects that the passed email address is without the @ombtp.com on the 
	 * end. If a circle does not exist with the passed email address, 0 is 
	 * returned.
	 */
	function getCircleID_email($email){
		$this->db->select('id');
		$this->db->from('circles');
		$this->db->where('email', $email);
		$query = $this->db->get();
		
		$row = $query->row_array();
		if (empty($row)) return 0;
		else return $row['id'];
	}

	/**
	 * Returns the permissions of the passed user in the passed circle, Returns 
	 * NULL if the user is not a member of that circle.
	 */
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
	
	/**
	 * Returns true if the passed user is in the passed circle and false otherwise
	 */
	function getMembers($circle_id) {
		$this->db->select('users.phone_number, providers.gateway, users_circles.user_id');
		$this->db->from('users');
		$this->db->join('users_circles', 'users_circles.user_id = users.id');
		$this->db->join('providers', 'users.provider_id = providers.id');
		$this->db->where('users_circles.circle_id', $circle_id);

		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * Returns the id of the circle with the passed email address. This method 
	 * expects that the passed email address is without the @ombtp.com on the 
	 * end. If a circle does not exist with the passed email address, 0 is 
	 * returned.
	 */
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
	
	/**
	 * Returns the id of the circle with the passed email address. This method 
	 * expects that the passed email address is without the @ombtp.com on the 
	 * end. If a circle does not exist with the passed email address, 0 is 
	 * returned.
	 */
	function isMember($user_id, $circle_id) {
		
		$this->db->select();
		$this->db->from('users_circles');
		$this->db->where('circle_id', $circle_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		
		$results = $query->result();
		
		return (!empty($results));
	}

	function setDescription($circle_id, $description) {
		$this->db->where('circles.id', $circle_id);
		$this->db->update('description', $description);
	}

	function getInfo($circle_id) {
		$this->db->select('description, name');
		$this->db->from('circles');
		$this->db->where('circles.id', $circle_id);
		$query = $this->db->get();

		$results = $query->result();

		if (empty($results)) return NULL;
		else return $results[0];
	}

	function setPrivacy($circle_id, $privacy) {
		$this->db->where('circles.id', $circle_id);
		$this->db->update('privacy', $privacy);
	}
}
