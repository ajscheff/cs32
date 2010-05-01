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

		$regex_pattern_num = "/[0-9]{10}@/";
		preg_match_all($regex_pattern_num, $_POST['from'], $num_matches);

		$regex_pattern_email = "/[a-zA-Z0-9]*@ombtp.com/";
		preg_match_all($regex_pattern_email, $_POST['to'], $email_matches);

		$numberFrom = substr($num_matches[0][0], 0, 10);
		$email = $email_matches[0][0];
		$email = substr($email, 0, strpos($email, '@'));

		$this->db->set('from', $numberFrom); //for debugging, remove later
		$this->db->set('to', $email);
		$this->db->set('message', $_POST['text']);
		$this->db->insert('email_test');

		//get the user and circle id's, will be 0 if they dont exist
		$user_id = $this->Users->getUserID_phone($numberFrom);
		$circle_id = $this->Circles->getCircleID_email($email);
		
		if ($this->Circles->isMember($user_id, $circle_id)) {

			//if the phone number exists in our database
			if ($user_id != 0) {
				if($circle_id != 0) {
					//$this->Messages->validMessageReceived($user_id, $circle_id, $email, $_POST['text']);
					$this->Messages->validMessageReceived(1, 1, 'mobiteam', 'test');
				}
				else {
					//circle doesn't exists.. send reply?
				}
			}
			else {
				//phone doesn't exist, send reply?
			}
		}
		else {
			//user is not a member of the circle, send reply?
		}
	}
}
