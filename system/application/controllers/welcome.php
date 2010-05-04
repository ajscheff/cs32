<?php

/**
*	
*/
class Welcome extends Controller {

	function Welcome() {
		parent::Controller();	
		$this->load->model('Users');
		$this->load->helper('AccountsHelper');
		$this->load->library('session');
	}
	
	function index() {
		$user_id = $this->session->userdata('user_id');
		$username = $this->session->userdata('username');
		$password = $this->session->userdata('password');
		if ($user_id != false && $username != false && $password != false) {
			if ($this->Users->passwordMatches($user_id, $password)) {
				$this->loadHomeView($user_id);
			} else {
				$this->load->view('login');
			}
		} else {
			$this->load->view('login');
		}
	}
	
	function logout() {
		$this->session->sess_destroy();
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
			if($this->Users->passwordMatches($user_id, $_POST['password'])){
				$session_data = array(
								'username' => $username,
								'password' => $_POST['password'],
								'user_id' => $user_id
							);
				$this->session->set_userdata($session_data);
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
	
	/**returns 0 if the username does not alraedy exist.  non-zero (user_id) otherwise.*/
	function usernameExists($username){
		return $this->Users->getUserID_username($username);
	
	}
	
	private function loadHomeView($user_id){
		$data['username'] =$this->Users->getUsername($user_id);
		$data['circles'] = $this->Users->getCircles($user_id);
		echo $this->load->view('home', $data);
	}
	
	function pregReplaceTest() {
		$message = "1 of 3\nMESSAGE\n--Original Message--asdfasdfasdfasdgahkl";
		//echo $message;
		$pattern_1 = "/1 of [0-9]*/";
		$message = preg_replace($pattern_1, '', $message);
		$pattern_2 = "/-*Original Message-*.*/";
		$message = preg_replace($pattern_2, '', $message);
		echo $message;
		//echo $test1;
		//echo $test2;
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
