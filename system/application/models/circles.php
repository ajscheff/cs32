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
	 * This function creates a cirlce with the passed parameters.  Assumes
	 * that the email address is not already taken
	 */
	function createCircle($circle_name, $email, $privacy, $description) {
	
		$this->db->set('name', $circle_name);
		$this->db->set('email', $email);
		$this->db->set('privacy', $privacy);
		$this->db->set('description', $description);
		$this->db->insert('circles');
		
		return $this->getCircleID_email($email);	
	}
	
	/**
	 * Returns the id of the circle with the passed email address. This method 
	 * expects that the passed email address is without the @ombtp.com on the 
	 * end. If a circle does not exist with the passed email address, 0 is 
	 * returned.
	 */
	function getCircleID_email($email) {
	
		$this->db->select('id');
		$this->db->from('circles');
		$this->db->where('email', $email);
		$query = $this->db->get();
		
		$queryResults = $query->result();
		
		if (empty($queryResults)) return 0;
		else return $queryResults[0]->id;
		
	}
	
	
	/**
	 * Returns an array of members of the circle. These are objects with the 
	 * following fields: 'public_name' (public name of user), 'phone_number', 
	 * 'gateway' (gateway associated with the user's provider), 'admin' (1 if 
	 * the user is an admin in this circle, 0 otherwise), 'public_name' (the 
	 * public name of the member of the circle)
	 */
	function getMembers($circle_id) {
		$this->db->select('users.phone_number, providers.gateway, users_circles.user_id, users_circles.public_name');
		$this->db->from('users');
		$this->db->join('users_circles', 'users_circles.user_id = users.id');
		$this->db->join('providers', 'users.provider_id = providers.id');
		$this->db->where('users_circles.circle_id', $circle_id);

		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * Returns an array of admins of the circle.  These are objects with the 
	 * same fields as above except for no 'admin' field.
	 */
	function getAdmins($circle_id) {
		$this->db->select('users.phone_number, providers.gateway, users_circles.user_id, users_circles.public_name');
		$this->db->from('users');
		$this->db->join('users_circles', 'users_circles.user_id = users.id');
		$this->db->join('providers', 'users.provider_id = providers.id');
		$this->db->where('users_circles.circle_id', $circle_id);
		$this->db->where('users_circles.admin', 1);
		
		$query = $this->db->get();
		return $query->result();
	}	
	
	/**
	 * Returns true if the passed user is in the passed circle and false 
	 * otherwise.
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

	/**
	* Sets the decription of the circle with id $circle_id to $description.
	*/
	function setDescription($circle_id, $description) {
		$this->db->where('circles.id', $circle_id);
		$this->db->update('description', $description);
	}

	/**
	* Returns the description of the circle with id $circle_id.
	*/
	function getInfo($circle_id) {
		$this->db->select('description, name');
		$this->db->from('circles');
		$this->db->where('circles.id', $circle_id);
		$query = $this->db->get();

		$results = $query->result();

		if (empty($results)) return NULL;
		else return $results[0];
	}

	/**
	 * Sets searchability of the group, expects 'public', 'private', 'secret'.
	 */
	function setPrivacy($circle_id, $privacy) {
		$this->db->where('circles.id', $circle_id);
		$this->db->update('privacy', $privacy);
	}
	
	function getPrivacy($circle_id) {
		$this->db->select('privacy');
		$this->db->from('circles');
		$this->db->where('circles.id', $circle_id);
		$query = $this->db->get();
		
		$result = $query->result();
		
		return $result[0]->privacy;
	}
}
