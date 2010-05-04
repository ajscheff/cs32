<?php

/**
*	
*/
class Welcome extends Controller {

	function Welcome() {
		parent::Controller();	
		$this->load->model('Users');
		$this->load->helper('AccountsHelper');
		
	}
	
	function index() {
		$this->load->view('login');
	}
	
	
	function signup(){
		$username = $_POST['username'];
		$user_id = $this->Users->getUserID_username($username);
		if($user_id == 0){
			$user_id = $this->Users->createFullUser($username, $_POST['password'], $_POST['phone_number'], $_POST['provider_id'], $_POST['public_name']);
			$this->loadHomeView($user_id);
		}
		else{
			echo 'Please choose another username'; //this should never be reached if the view never requests a taken username
		
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
			$this->loadHomeView($user_id);
			}
			else{
				echo 'You\'re username did not match that password!';
			}
		}
		else {
			echo 'You\'re username did not match that password!';
		}
	}
	
	private function loadHomeView($user_id){
		$data['username'] =$this->Users->getUsername($user_id);
		$data['circles'] = $this->Users->getCircles($user_id);
		echo $this->load->view('home', $data);
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */