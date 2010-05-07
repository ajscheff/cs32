<?php

class Messages extends Model {

	var $title   = '';
	var $content = '';
	var $date    = '';

	/**
	 * This is the constructor for the Messages model that loads the database.
	 */
	function Messages() {
		// Call the Model constructor
		parent::Model();
		$this->load->database();
		$this->load->library('email');
	}

	/**
	 * Sends a from the $from to $to. This method does NOT check for 
	 * permissions, circles, or validity of the email.
	 */
	function send($from, $to, $message){
		$this->email->from($from);
		$this->email->to($to); 
		$this->email->message($message);	
		$this->email->send();
	}

	/**
	 * This is for testing only. This should not be called outside of a testing
	 * environment.
	 */
	function sendTest() {
		$this->email->from('thewebsite@ombtp.com');
		$this->email->to('4015276563@txt.att.net'); 
		$this->email->bcc('walterblaurock@gmail.com, andyscheff@gmail.com');
		$this->email->message('this is an sms message sent through sendgrid from the website');	
		$this->email->send();
	}
	
	/**
	 * Sends out a message to all members of a circle. Should only be called 
	 * when it is confirmed that the message is valid.
	 */
	function validMessageReceived($user_id, $circle_id, $circle_email, $message) {
	
		$pattern_1 = "/^1 of [0-9]*(\n)*/";
		$message = preg_replace($pattern_1, '', $message);
		$pattern_2 = "/-*Original Message-*(.|\n)*/";
		$message = preg_replace($pattern_2, '', $message);
		$pattern_3 = "/(-|=|\n)*This mobile text message is brought to you by AT&T(.|\n)*/";
		$message = preg_replace($pattern_3, '', $message);	
		
		$this->load->model('Circles');

		// insert message into database
		$this->db->set('text', $message);
		$this->db->set('user_id', $user_id);
		$this->db->set('circle_id', $circle_id);
		$this->db->insert('messages');

		$userPermissions = $this->Circles->getPermissions($user_id, $circle_id);

		if ($userPermissions == 'reply_all') {
			$emailList = $this->Circles->getAllMembers($circle_id);
		}
		else if ($userPermissions == 'reply_admins') {
			$emailList = $this->Circles->getAdmins($circle_id);
		}
		else {
			$emailList = array();
			//user has invalid permissions.  send notification?
		}
		
		$this->load->model('Users');

		foreach ($emailList as $contact) {
			if ($user_id != $contact->user_id) {				
				$publicname = $this->Users->getUsername($user_id, $circle_id);
				$message = ' ' . $publicname . ': ' . $message;
				$from = $circle_email . '@ombtp.com';
				$this->send($from, $contact->phone_number.'@'.$contact->gateway, $message);
			}
		}
	}
	
	/**
	 * Returns an array of most recent $number of messages for a given circle, 
	 * beginning with the message at the index $first_message. Elements of array
	 * are object with the following public fields: 'public_name' (sender of 
	 * message), 'timestamp', 'text'.
	 */
	function getMessages_circle($circle_id, $first_message, $number) {
		$this->db->select('messages.user_id, users_circles.public_name, messages.text, messages.timestamp');
		$this->db->from('messages');
		$this->db->where('messages.circle_id', $circle_id);
		$this->db->join('users_circles', 'messages.circle_id = users_circles.circle_id AND messages.user_id = users_circles.user_id');
		$this->db->order_by('timestamp', 'desc');
		$this->db->limit($number, $first_message);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	/**
	 * Returns an array of most recent $number of messages for a given user, 
	 * beginning with the message at the index $first_message. Elements of array
	 * are object with the following public fields: 'name' (group to which 
	 * message was sent), 'timestamp', 'text'.
	 */
	function getMessages_user($user_id, $first_message, $number) {
		$this->db->select('messages.circle_id, users_circles.public_name, messages.text, messages.timestamp');
		$this->db->from('messages');
		$this->db->where('messages.user_id', $user_id);
		$this->db->join('users_circles', 'messages.user_id = users_circles.user_id AND messages.circle_id = users_circles.circle_id');
		$this->db->order_by('timestamp', 'desc');
		$this->db->limit($number, $first_message);	
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
}
