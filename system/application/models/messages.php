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



		if (strcmp($userPermissions, 'reply_all')) {
			echo 'reply all';
			$emailList = $this->Circles->getMembers($circle_id);
		}
		else if (strcmp($userPermissions, 'reply_admins')) {
			$emailList = $this->Circles->getAdmins($circle_id);
		}
		else {
			$emailList = array();
			//user has invalid permissions.  send notification?
		}

		foreach ($emailList as $contact) {
			$this->send($circle_email.'@ombtp.com', $contact->phone_number.'@'.$contact->gateway, $message);
		}
	}
}
