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
		//
		
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
			$data = $this->getUserHomeData($user_id);
			echo $this->load->view('home', $data);
			}
			else{
				echo 'You\'re username did not match that password!';
			}
		}
		else {
			echo 'You\'re username did not match that password!';
		}
	}
	
		//test function
	function quickTest() {
		$this->load->model('Messages');
		$this->Messages->sendTest();
	}
	
	private function getUserHomeData($user_id){
		$data['username'] =$this->Users->getUsername($user_id);
		$data['circles'] = $this->Users->getCircles($user_id);
		return $data;
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */