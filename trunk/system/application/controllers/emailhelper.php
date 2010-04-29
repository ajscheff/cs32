<?php

/**
*	
*/
class EmailHelper extends Controller {

	function EmailHelper() {
		parent::Controller();		
	}
	
	
	function receive(){
	
		$this->load->database();
		$this->load->model('Users');
		$this->load->model('Circles');
		$this->load->model('Messages');

		$this->db->set('from', $_POST['from']); //for debugging, remove later
		$this->db->set('to', $_POST['to']);
		$this->db->set('message', $_POST['text']);
		$this->db->insert('email_test');

		//get the phone number that the email was sent from
		$numberFrom = substr($_POST['from'], 1, 10);
		$email = substr($_POST['to'], 0, strlen($_POST['to'])-11);

		$this->db->set('from', $numberFrom); //for debugging, remove later
		$this->db->set('to', $email);
		$this->db->set('message', $_POST['text']);
		$this->db->insert('email_test');

		//get the user and circle id's, will be 0 if they dont exist
		$user_id = $this->Users->getUserID_phone($numberFrom);
		$circle_id = $this->Circles->getCircleID_email($email);

		//if the phone number exists in our database
		if ($user_id != 0) {
			if($circle_id != 0) {
				$this->Messages->validEmailReceived($user_id, $circle_id, $email, $_POST['text']);
			}
			else {
				//circle doesn't exists.. send reply?
			}
		}
		else {
			//phone doesn't exist, send reply?
		}
		
	}
}
