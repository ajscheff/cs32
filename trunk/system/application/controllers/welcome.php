<?php

/**
*	
*/
class Welcome extends Controller {

	function Welcome() {
		parent::Controller();	
		$this->load->model('Users');
		
	}
	
	function index() {
		$this->load->view('login');
	}
	
	
	function createUser(){
		$username = $_POST['username'];
		
		if($this->Users->usernameExists($username))
			echo $_POST['username'].' is already taken! Please choose another login.';
		else {
			$this->Users->createFullUser($username, $_POST['password'], $_POST['phonenumber'], $_POST['provider_id'], $_POST['public_name']);
			$data['username'] = $username;
			$data['circles'] = $getCircles($username);
			echo $this->load->view('home', $data);
		}
	}
	
	/**
	If the username and password retrieved are valid, loads home view with data containing
	username and circles for the user.  See getCircles() for format of 'circles' array
	*/
	function login(){
		$username = $_POST['username'];
		if($this->Users->usernameExists($username)){
			if($this->Users->passwordMatches($username, $_POST['password'])){
			$data['username'] = $username;
			$data['circles'] = array(array('name' => "Friends", 'members' => array("sboger", "ljabr"), 'messages' => array("this is a message!", "THIS is a message!")), array('name' => "Work", 'members' => array("mgartner", "ascheff"), 'messages' => array("this IS a message!", "this is a MESSAGE!")));//getCircles($username);
			echo $this->load->view('home', $data);
		}
		}
		else {
			echo 'You\'re username did not match that password!';
		}
	}
	
	function sendEmail(){
		$this->load->library('email');

		$this->email->from('magartner@gmail.com', 'Your Name');
		$this->email->to('marcus_gartner@brown.edu');

		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');

		$this->email->send();

		echo $this->email->print_debugger();
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

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
