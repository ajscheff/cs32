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

		$regex_pattern_email = "/[a-zA-Z0-9_]*@ombtp.com/";
		preg_match_all($regex_pattern_email, $to, $email_matches);

		$numberFrom = substr($num_matches[0][0], 0, 10);
		$email = $email_matches[0][0];
		$email = substr($email, 0, strpos($email, '@'));
		$gateway = substr($from, strpos($from, $numberFrom) + 11);

		$this->db->set('from', $numberFrom); //for debugging, remove later
		$this->db->set('to', $email);
		$this->db->set('message', $message);
		$this->db->insert('email_test');

		//process message for commands
		$temp_msg = $message;
		$temp_msg = trim($temp_msg);
		$temp_msg = strtok($temp_msg, ' ');
		
		/**
		*  Parsing for in-text commands
		*/
		if(strncasecmp($temp_msg, '#signup', 7) == 0){
			$user_id = $this->Users->getUserID_phone($numberFrom);
			$reply = '';
			if($user_id != 0){
				$reply = 'You already have an account registered with mobi.com. Text "#help" for further options.';
			}
			else{
				$temp_msg = strtok(' ');
				$username_taken = $this->Users->getUserID_username($temp_msg);
				if($username_taken == 0){
					$temp_password = 'tharsheblows';
					$this->Users->createFullUser($temp_msg, $temp_password, $numberFrom, $temp_msg);

					$reply = "Welcome to Mobi!  Your temporary password is $temp_password.  Please visit mobi.com to change your password.";
				}
				else{

					$reply = 'This username is already taken.  Please resubmit your signup request with a different username.';
				}
			}
			$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, $reply);	
			return;
		}
		
		elseif(strncasecmp($temp_msg, '#help', 5) == 0){
			$user_id = $this->Users->getUserID_phone($numberFrom);
			$reply = '';
			if($user_id == 0){
				$reply = 'Text \'#signup\' to register an account with mobi!';
			}
			else{
				$reply = '#addme <circle_email> #newcircle <circle_email>';
			}
			$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, $reply);
			return;
		
		}
		
		elseif(strncasecmp($temp_msg, '#test', 5) == 0){
			$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, 'test');
			return;
		}
		
		elseif(strncasecmp($temp_msg, '#addme', 6) == 0){
			$user_id = $this->Users->getUserID_phone($numberFrom);
			if($user_id == 0){
				$this->sendNotRegisteredMsg($numberFrom, $gateway);
			}
				//phone number belongs to a registered user
			else{
				$circle_id = $this->Circles->getCircleID_email($email);
				if($circle_id == 0){//circle doesn't exist
					$reply = "The circle to which you have tried to add yourself does not exist.  To create a circle with this address, text '#makecircle' to $email@ombtp.com";
					$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, $reply);
					return;
				}
					//circle exists
				else{
					$reply = '';
						//user is already a memeber of this circle
					if($this->Circles->isMember($user_id, $circle_id)){
						$reply = "You are already a member of $temp_msg!";
					}
						//user is not already a member of this circle
					else{
						$privacy = $this->Circles->getPrivacy($circle_id); //find if circle is public or private
						if($privacy == 'public'){
							$reply = "You have been successfully added to the circle with address $email.";
							$this->Users->addUserToCircle($user_id, $circle_id);
						}
						else{
							$reply = 'You are not authorized to add yourself to this circle.';
						} 
					}
					$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, $reply);
					return;
				}
			}
		}
		
		elseif(strncasecmp($temp_msg, '#makecircle', 11) == 0){
			$user_id = $this->Users->getUserID_phone($numberFrom);
			if($user_id == 0){
				$this->sendNotRegisteredMsg($numberFrom, $gateway);
				return;
			}
			else{
				$temp_msg = strtok(' ');
				$circle_id = $this->Circles->getCircleID_email($email);
				$reply = '';
				if($circle_id != 0){//circle doesn't exist
					$reply = "The circle to which you have tried to create already exists.  Please select a different email address for your new circle, $temp_msg.";
				}
					//circle can be added
				else{
					$reply = "Circle $temp_msg has been created successfully!  Go online to change the settings of this circle.";
					$circle_id = $this->Circles->createCircle($user_id, $temp_msg, $email, 'public', 'this circle was created by text message!');
				}
				$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, $reply);
				return;
			}
		}
		
		elseif(strncasecmp($temp_msg, '#mycircles', 10)){
			$user_id = $this->Users->getUserID_phone($numberFrom);
			if($user_id == 0){
				$this->sendNotRegisteredMsg($numberFrom, $gateway);
				return;
			}
			else{
				$reply_length = 0;
				$reply = '';
				$circles = $this->Users->getCircles($user_id);
				foreach($circles as $circle){
					$email = $this->Circles->getEmail($circle->id));
					$email_length = strlen($email);
					//$reply_length += $email_length + 1;
					if($reply_length <= 160){
						//$reply .= $email.' ';
					}
					else{
						break;
					}
				}
				$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, $reply);
				return;
			}
		}
		
		elseif(strncasecmp($temp_msg, '#add', 4) == 0){
			$user_id = $this->Users->getUserID_phone($numberFrom);
			if($user_id == 0){
				$this->sendNotRegisteredMsg($numberFrom, $gateway);
				return;
			}
			else{
				$circle_id = $this->Circles->getCircleID_email($email);
				$reply = '';
				if($circle_id == 0){
					$reply = 'The circle to which you have tried to add users does not exist.';
				}
				else{
					$temp_msg = strtok(' ');
						//add all the numbers to the circle
					$all_success = true;
					while($temp_msg != false){
						$user_toAdd_id = $this->Users->getUserID_phone($temp_msg);
						if($user_toAdd_id != 0){
							if($this->Users->isMember($user_toAdd_id, $circle_id)){
								$local_reply = "The number $temp_msg belongs to a user who is already a member of this circle.";
								$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, $local_reply);
								$all_success = false;
							}
							else{
								$this->Users->addUserToCircle($user_toAdd_id, $circle_id);
							}
						}
						else{
							$local_reply = "The number $temp_msg does not belong to a registered Mobi user.  Text '#addnewuser $temp_msg nameofnewuser' to $email@ombtp.com";
							$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, $local_reply);
							$all_success = false;
						}
					}
					if(all_success){
						$reply = "All users have been added to $email successfully";
					}
				}
				$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, $reply);
			}
		}
		
		
		/**
		*  The user is probably trying to send a message to a circle...
		*/
		else{
		//get the user and circle id's, will be 0 if they dont exist
		$user_id = $this->Users->getUserID_phone($numberFrom);
		$circle_id = $this->Circles->getCircleID_email($email);
					
			//if the phone number exists in our database	
			if ($user_id != 0) {
				if($circle_id != 0) {
					if ($this->Circles->isMember($user_id, $circle_id)) {
						$this->Messages->validMessageReceived($user_id, $circle_id, $email, $_POST['text']);
					}
					//user is not a member of the circle
					else {
						//circle is public
						$privacy = $this->Circles->getPrivacy($circle_id);
						if($privacy == 'public'){
							$reply = "You are not a member of this circle.  To add yourself, text '#addme' to $email@ombtp.com'";
							$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, $reply);
							return;
						}
						//if the circle is private, don't inform user that it exists: do nothing
					}
				}
				else {
					//circle doesn't exist
					$reply = "The circle to which you have tried to post does not exist.  To create a circle with this address, text \'#makecircle nameofmynewcircle\' to $email@ombtp.com";
					$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, $reply);
					return;
				}
			}
			else {
				//phone doesn't exist; user is not registered
				$this->sendNotRegisteredMsg($numberFrom, $gateway);
				return;
			}
		}
	}
	
	private function sendNotRegisteredMsg($numberFrom, $gateway){
		$reply = 'You don\'t have an account with Mobi yet!  Text \'#signup yourusername\' to admin@ombtp.com to make one!';
		$this->Messages->send('admin@ombtp.com', $numberFrom.'@'.$gateway, $reply);
	}
}
