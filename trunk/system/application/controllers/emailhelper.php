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

		//get the phone number that the email was sent from
		$numberFrom = substr($_POST['from'], 0, 10);
		$email = explode('<', $_POST['to'])[1];
		$email = explode('@', $email)[0];

		//get the user and circle id's, will be 0 if they dont exist
		$user_id = $this->Users->phoneExists($number);
		$circle_id = $this->Circles->circleExists($email);

		//if the phone number exists in our database
		if ($user_id != 0) {
			if($circl_id != 0) {
				$this->Messages->validEmailReceived($user_id, $circle_id, $_POST['text'];
			}
			else {
				//circle doesn't exists.. send reply?
			}
		}
		else {
			//phone doesn't exist, send reply?
		}
	}
	
	function test() {
		$this->load->model('Users');
		$this->Users->getPermissions(1, 1);
	}
}
