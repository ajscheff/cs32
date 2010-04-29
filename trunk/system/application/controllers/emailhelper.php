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
		/*$numberFrom = substr($_POST['from'], 1, 10);
		$email = substr($_POST['to'], 0, strlen($_POST['to'])-11);

		$this->db->set('from', $numberFrom); //for debugging, remove later
		$this->db->set('to', $email);
		$this->db->set('message', $_POST['text']);
		$this->db->insert('email_test');*/

		//get the user and circle id's, will be 0 if they dont exist
		$user_id = $this->Users->phoneExists('4015276563');
		$circle_id = $this->Circles->circleExists('mobiteam');

		echo $user_id;
		echo $circle_id;
		echo 'dafksda';
		
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

		

		//$this->Messages->validEmailReceived(1, 1, 'mobiteam', 'message');
		
	}
}
