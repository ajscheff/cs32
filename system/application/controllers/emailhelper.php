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

		$from = $_POST['from'];
		$to = $_POST['to'];
		$message = $_POST['text'];
		
		$this->db->set('from', $from); //for debugging, remove later
		$this->db->set('to', $to);
		$this->db->set('message', $message);
		$this->db->insert('email_test');

		//get the phone number that the email was sent from
		$regex_pattern_num = "/[0-9]{10}@/";
		preg_match_all($regex_pattern_num, $from, $num_matches);

		$regex_pattern_email = "/[a-zA-Z0-9]*@ombtp.com/";
		preg_match_all($regex_pattern_email, $to, $email_matches);

		$numberFrom = substr($num_matches[0][0], 0, 10);
		$email = $email_matches[0][0];
		$email = substr($email, 0, strpos($email, '@'));
		
		$gateway = substr($from, strpos($from, $numberFrom) + 11);
		$provider_id = $this->Users->getProviderID($gateway);
		if($provider_id == 0){
			$provider_id == $this->Users->addProvider($gateway);
		}

		$this->db->set('from', $numberFrom); //for debugging, remove later
		$this->db->set('to', $email);
		$this->db->set('message', $message);
		$this->db->insert('email_test');

		//process message for commands
		$temp_msg = $message;
		$temp_msg = trim($temp_msg);
		$temp_msg = strtok($temp_msg, ' ');
		if(strncasecmp($temp_msg, '#signup', 7) == 0){
			$user_id = $this->Users->getUserID_phone($numberFrom);
			$reply = '';
			if($user_id != 0){
				$reply = 'You already have an account registered with mobi.com. Text "#help" for further options.';
			}
			else{
				$temp_msg = strtok(' ');
				$this->Users->createStubUser($numberFrom, $provider_id);
				$reply = 'Welcome to mobi!  Go to mobi.com to create a username and password.';
			}
			$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, $reply);		
		}
		
		elseif(strncasecmp($temp_msg, '#help', 5) == 0){
			$user_id = $this->Users->getUserID_phone($numberFrom);
			$reply = '';
			if($user_id == 0){
				$reply = 'Text \'#signup\' to register an account with mobi!';
			}
			else{
				$reply = 'There are no other text commands supported at this time.';
			}
			$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, $reply);
		
		}
		
		elseif(strncasecmp($temp_msg, '#test', 5) == 0){
			$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, 'test');
		}
		
		else{
		
		//
		
		
			//get the user and circle id's, will be 0 if they dont exist
			$user_id = $this->Users->getUserID_phone($numberFrom);
			$circle_id = $this->Circles->getCircleID_email($email);
					
			if ($this->Circles->isMember($user_id, $circle_id)) {

				//if the phone number exists in our database	
				if ($user_id != 0) {
					if($circle_id != 0) {
						$this->Messages->validMessageReceived($user_id, $circle_id, $email, $_POST['text']);
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
}
