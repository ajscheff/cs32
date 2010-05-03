<?php

/**
*	
*/
class Welcome extends Controller {

	private $helper = null;

	function Welcome() {
		parent::Controller();	
		$this->load->model('Users');
		//$helper = new accountshelper();
		
	}
	
	function index() {
		$this->load->view('login');
	}
	
	
	function signup(){
		$user_id = $helper->createUser($_POST['username'], $_POST['password'], $_POST['phonenumber'], $_POST['provider_id'], $_POST['public_name']);
		if($user_id == 0)
			echo $_POST['username'].' is already taken! Please choose another login.';
		else {
			$data = $helper->getUserHomeData($user_id);
			echo $this->load->view('home', $data);
		}
	}
	
	/**
	If the username and password retrieved are valid, loads home view with data containing
	username and circles for the user.  See getCircles() for format of 'circles' array
	*/
	function login(){
		$username = $_POST['username'];
		$user_id = $this->Users->getUserID_username($username);
		if($user_id != 0){
			if($this->Users->passwordMatches($username, $_POST['password'])){
			$data = getUserHomeData($user_id);
			echo $this->load->view('home', $data);
		}
		}
		else {
			echo 'You\'re username did not match that password!';
		}
	}

	function quickTest() {
		$this->load->model('Messages');
		$this->Messages->sendTest();
	}
	
	function createUser($username, $password, $phonenumber, $provider_id, $public_name){	
		if($this->Users->getUserID_username($username) != 0)
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
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
