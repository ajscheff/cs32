<?php

class Messages extends Model {

	var $title   = '';
	var $content = '';
	var $date    = '';

	function Messages()
	{
		// Call the Model constructor
		parent::Model();
		$this->load->database();
		$this->load->library('email');
	}

	function send($from, $to, $message){
		$this->email->from($from);
		$this->email->to($to); 
		$this->email->message($message);	
		$this->email->send();
	}
	
	function validMessageReceived($user_id, $circle_id, $circle_email, $message) {

		// insert message into database
		$this->db->set('text', $message);
		$this->db->set('user_id', $user_id);
		$this->db->set('circle_id', $circle_id);
		$this->db->insert('messages');

		$this->load->model('Circles');

		$userPermissions = $this->Circles->getPermissions($user_id, $circle_id);

		if ($userPermissions == 'reply_all') {
			$emailList = $this->Circles->getMembers($circle_id);
		}
		else if ($userPermissions == 'reply_admins') {
			$emailList = $this->Circles->getAdmins($circle_id);
		}
		else {
			$emailList = array();
			//user has invalid permissions.  send notification?
		}

		foreach ($emailList as $contact) {
			//if ($user_id != $contact->user_id) {
				$this->send($circle_email.'@ombtp.com', $contact->phone_number.'@'.$contact->gateway, $message);
			//}
		}
	}
	
	function getMessages_circle($circle_id, $first_message, $number) {
		$this->db->select('messages.user_id, users.public_name, messages.text, messages.timestamp');
		$this->db->from('messages');
		$this->db->join('users', 'messages.user_id = users.id');
		$this->db->limit($first_message, $number);
		
		$query = $this->db->get();
		
		return $query->result;
	}
	
	function getMessages_user($user_id, $first_message, $number) {
		$this->db->select('messages.circle_id, users.public_name, messages.text, messages.timestamp');
		$this->db->from('messages');
		$this->db->join('users', 'messages.user_id = users.id');
		$this->db->limit($first_message, $number);	
		
		$query = $this->db->get();
		
		return $query->result;
	}
}
