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
		$this->load->model('Circles');
		$this->load->model('Messages');
	}
	
	/**
	 * This method returns the user id associated with the passed username
	 * if the username does not exist in the db, this method returns 0
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

	/**
	 * This method returns the user id associated with the passed phone number
	 * if the phone number does not exist in the db, this method returns 0
	 */
	function getUserID_phone($phone_number){
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('phone_number', $phone_number);
		$query = $this->db->get();
		
		$rows = $query->result();
		if (empty($rows)) return 0;
		else return $rows[0]->id;
	}
	
	/**
	 * This method returns the username of the user with the passed user id
	 * if the passed user id doesn't exist in the db, this method returns NULL
	 */
	function getUsername($user_id) {
		$this->db->select('username');
		$this->db->from('users');
		$this->db->where('users.id', $user_id);
		
		$query = $this->db->get();
		
		$rows = $query->result();
		if (empty($rows)) return NULL;
		else return $rows[0]->username;
	}
	
	/**
	 * This method returns the public name of the user with the passed user id
	 * if the passed user id doesn't exist in the db, this method returns NULL
	 */
	function getPublicName($user_id, $circle_id) {
		$this->db->select('public_name');
		$this->db->from('users_circles');
		$this->db->where('user_id', $user_id);
		$this->db->where('circle_id', $circle_id);		
		$query = $this->db->get();
		
		$rows = $query->result();
		if (empty($rows)) return NULL;
		else return $rows[0]->public_name;
	}
	
	/**
	 * This method returns true if the passed username and password match in the
	 * database and false if the username doesn't exist or the password is incorrect
	 */
	function passwordMatches($user_id, $password){
		$this->db->select('password');
		$this->db->from('users');
		$this->db->where('id', $user_id);
		$query = $this->db->get();
		
		$rows = $query->result();
		if(sizeof($rows) == 1)
			return ($this->pwEncode($password) == $rows[0]->password);
		else return false;
	}
	
	/**
	 * Returns the gateway associated with the provider id.
	 */
	function getProvider($provider_id) {
		$this->db->select('gateway');
		$this->db->from('providers');
		$this->db->where('id', $provider_id);
		
		$query = $this->db->get();
		
		$rows = $query->result();
		if (empty($rows)) return NULL;
		else return $rows[0]->gateway;
	}

	/**
	 * This method creates a stub user (a user with only a phone number and a provider)
	 * in the database and returns the user id associated with the new user.
	 */
	function createStubUser($phone_number)
	{
	
		$provider_id = $this->internetLookupProvider($phone_number);
	
		$this->db->set('phone_number', $phone_number);
		$this->db->set('provider_id', $provider_id);
		$this->db->insert('users');
		
		$gateway = $this->getProvider($provider_id);
		$reply = "You have been invited to join Mobi: The Mobile Social Network. Visit mobi.com or text '#upgrademe myusername' to admin@ombtp.com to create a full account.";
		$this->Messages->send("$circle_email@ombtp.com", $phone_number.'@'.$gateway, $reply);
		
		return $this->getUserID_phone($phone_number);
	}
	
	/**
	 * This method returns the provider id associated with the passed gateway
	 * this method will return 0 if the passed gateway isn't recognized by the db
	 */
	function getProviderID($gateway) {
		
		$this->db->select('id');
		$this->db->from('providers');
		$this->db->where('gateway', $gateway);
		
		$query = $this->db->get();
		
		$rows = $query->result();
		if (empty($rows)) return 0;
		else return $rows[0]->id;
	}
	
	/**
	 * Returns the provider ID associated to a particular user.
	 */
	 function getProviderID_user($user_id) {
	 	$this->db->select('provider_id');
	 	$this->db->from('users');
	 	$this->db->where('users.provider_id', $user_id);
	 	
	 	$query = $this->db->get();
		$rows = $query->result();
		if (empty($rows)) return 0;
		else return $rows[0]->provider_id;
	 }
	
	/**
	 * This method creates a full user and returns the id associated with it
	 */
	function createFullUser($username, $password, $phone_number, $preferred_name) {
	
		$provider_id = $this->internetLookupProvider($phone_number);
		
		$this->db->set('username', $username);
		$this->db->set('password', $this->pwEncode($password));
		$this->db->set('phone_number', $phone_number);
		$this->db->set('provider_id', $provider_id);
		$this->db->set('preferred_name', $preferred_name);
		$this->db->insert('users');
		
		return $this->getUserID_username($username);
	}

	/**
	 * This method creates a full user and returns the id associated with it
	 */
	function upgradeUser($user_id, $username, $password, $preferred_name) {
		$data = array(
				'username' => $username,
				'password' => $password,
				'preferred_name' => $preferred_name);
		$this->db->where('users.id', $user_id);
		$this->db->update('users', $data);
	}
	
	/**
	 * This method gets all circles that the passed user id is a member of.  It returns an
	 * array of circle objects with fields 'name' 'id' 'admin' 'description'
	 */
	function getCircles($user_id) {
		$this->db->select('circles.name, circles.id, users_circles.admin, circles.description');
		$this->db->from('circles');
		$this->db->join('users_circles', 'users_circles.circle_id = circles.id');
		$this->db->where('users_circles.user_id', $user_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	/**
	 * Returns the phone number associated with the given user id.
	 */
	 function getPhone($user_id) {
	 	$this->db->select('phone_number');
	 	$this->db->from('users');
	 	$this->db->where('users.id', $user_id);
	 	$query = $this->db->get();
	 	$rows = $query->result();
		if (empty($rows)) return NULL;
		else return $rows[0]->phone_number;
	 }
	
	/**
	 * This method adds a user to a circle.  This method accepts a user id and a circle id
	 * and can accept an admin (1 or 0) or privledges ('reply_all, reply_admins, no_reply)
	 * it adds a line to the users_circle table to reflect the new group membership
	 */
	function addUserToCircle($user_id, $circle_id, $public_name = NULL, $admin = 0, $privledges = 'reply_all') {
		
		$userPreferredName = $this->getPreferredName($user_id);
		if ($userPreferredName != NULL) {
			$public_name = $userPreferredName;
		}
	
		$this->db->set('user_id', $user_id);
		$this->db->set('circle_id', $circle_id);
		$this->db->set('admin', $admin);
		$this->db->set('privileges', $privledges);
		$this->db->set('public_name', $public_name);
		$this->db->insert('users_circles');
		
		$circle_email = $this->Circles->getEmail($circle_id);
		$numberTo = $this->getPhone($user_id);
		$provider_id = $this->getProviderID_user($user_id);
		$gateway = $this->getProvider($provider_id);
		$reply = "You have been added to this circle.  Reply with #removeme to remove yourself.";
		$this->Messages->send("$circle_email@ombtp.com", $numberTo.'@'.$gateway, $reply);	
	}

	/**
	 * This method removes a the passed user from the passed circle
	 */
	function removeUserFromCircle($user_id, $circle_id) {
		$this->db->where('user_id', $user_id);
		$this->db->where('circle_id', $circle_id);
		$this->db->delete('users_circles');
	}
	
	/**
	 * Returns the preferred name of the passed user ID
	 */
	function getPreferredName($user_id) {
		$this->db->select('preferred_name');
		$this->db->from('users');
		$this->db->where('users.id', $user_id);
		
		$query = $this->db->get();
		$results = $query->result();
		
		return $results[0]->preferred_name;
	}
	
	/**
	 * sets the preferred name of the passed user
	 */
	function setPreferredName($user_id, $preferred_name) {
		$this->db->where('id', $user_id);
		$data = array('preferred_name' => $preferred_name);
		$this->db->update('users', $data);
	}
	
	
	/**
	 * Sets the public name of the passed user in the passed circle
	 */
	function setPublicName($user_id, $circle_id, $public_name) {
		$this->db->where('user_id', $user_id);
		$this->db->where('circle_id', $circle_id);
		$data = array('public_name' => $public_name);
		$this->db->update('users_circles', $dsata);
	}
	
	/**
	 * This method sets the admin status of the passed user in the passed
	 * circle.  Expects 1 or 0 for $admin, default is 1
	 */
	function setUserAdmin($user_id, $circle_id, $admin=1) {
		$this->db->where('user_id', $user_id);
		$this->db->where('circle_id', $circle_id);
		$data = array('admin' => $admin);
		$this->db->update('users_circles', $data);
	}
	
	
	function getUserAdmin($user_id, $circle_id) {
		$this->db->select('admin');
		$this->db->from('users_circles');
		$this->db->where('user_id', $user_id);
		$this->db->where('circle_id', $circle_id);
		
		$query = $this->db->get();
		$result = $query->result();
		
		return $result[0]->admin;
	}

	/**
	 * This method sets the privileges level for the passed user in the passed
	 * circle.  Expects reply_all, reply_admins, no_reply.
	 */
	function setUserPrivileges($user_id, $circle_id, $privileges) {
		$this->db->where('user_id', $user_id);
		$this->db->where('circle_id', $circle_id);
		$data = array('privileges' => $privileges);
		$this->db->update('users_circles', $data);
	}

	/**
	 * This method changes the password for the passed user to the passed password
	 */
	function changePassword($user_id, $password) {
		$this->db->where('id', $user_id);
		$data = array('password' => $this->pwEncode($password));
		$this->db->update('users', $data);
	}
	
	
	/**
	 * This method returns the provider id associated with the passed phone number
	 * this works for at&t, verizon, t-mobile, and Sprint numbers, returns 0 for
	 * an unrecognized number or provider.
	 */
	function internetLookupProvider($phoneNumber) {
	
		$url = 'http://www.whitepages.com/carrier_lookup?carrier=other&name_0=&number_0='.$phoneNumber.'&name_1=&number_1=&name_2=&number_2=&name_3=&number_3=&response=1';
		$site = file_get_contents($url);

		$numATT = substr_count($site, 'AT&T');
		if ($numATT > 1) return 1;
		
		$numVer = substr_count($site, 'Verizon');
		if ($numVer > 1) return 2;
		
		$numTMo = substr_count($site, 'T-Mobile');
		if ($numTMo > 1) return 3;
		
		$numSpr = substr_count($site, 'Sprint PCS');
		if ($numSpr > 1) return 4;

		return 0;
	}
	
	/**
	 * This is a helper method for password security.  It hashes the passed password
	 * for lookup in the db
	 */
	function pwEncode($password) {
		return md5($password.'129038j09j10m0dapa23j');
	}
}
