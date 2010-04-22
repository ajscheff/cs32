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
	
	function validEmailReceived($user_id, $circle_id, $circle_email, $message) {
		// insert message into database
		$this->db->set('text', $message);
		$this->db->set('user_id', $user_id);
		$this->db->set('circle_id', $circle_id);
		$this->db->insert('messages');

		$this->load->model('Circles');

		$userPermissions = $this->Circles->getPermissions($user_id, $circle_id);

		$emailList = $this->Circles->getMemberEmails($circle_id);
		
		foreach ($emailList as $contact) {
			$this->send($circle_email.'@ombtp.com', $contact->phone_number.'@'.$contact->gateway, $message);
		}

		if (strcmp($userPermissions, 'reply_all')) {

		}
		else if (strcmp($userPermissions, 'reply_admins')) {
			$emailList = $this->Circles->getAdminEmails($circle_id);
		}
		else {
			//user has invalid permissions.  send notification?
		}
		// get list of receivers

		// sends email out
	}
}
