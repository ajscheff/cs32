<?php

class AccountsHelper{

	function AccountsHelper(){
		$this->load->model('Users');
	}


			/** returns 0 if the user name is already taken, user_id upon successfully creating the new user */
	function createUser($username, $password, $phonenumber, $provider_id, $public_name){	
		if($this->Users->getUserID_username($username) == 0)
			return 0;
		else {
			return $this->Users->createFullUser($username, $password, $phonenumber, $provider_id, $public_name);
		}
	
	}
	
	function getUserHomeData($user_id){
		$data['username'] =$this->Users->getUsername($user_id);
		$data['circles'] = array(array('name' => "Friends", 'members' => array("sboger", "ljabr"), 'messages' => array("this is a message!", "THIS is a message!")), array('name' => "Work", 'members' => array("mgartner", "ascheff"), 'messages' => array("this IS a message!", "this is a MESSAGE!")));
		return $data;
	
	}
	
	function createCircle($name, $email_address, $description, $settings_array, $creator_id){
		
	
	
	}

/**
		returns an array of circles for the username passed in.  A function with the same name
		is called on the Model, and the resulting data is packaged and returned in the following
		format:
		-circles
			=circle1
				=circle name
				-circle members
					=mem1
					=mem2
			=circle2...
			=circle3...
	*/
/**	protected function getCircles($username){
		$result;// = $this->Users->getCircles($username);
		$rows = $result.row_array();
		$cirlces;
		$i = 0;
		foreach($rows as $element){
			$circle;
			$circle['name'] = $element['name'];
			//$circle['members'] = $this->Users->getMemebers($element['id']);
			$circles[$i] = $circle;
			$i += 1;
		}
		return $circles;
	}
	*/

}