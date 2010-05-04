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
			if ($this->Users->passwordMatches($username, $password)) {
				$this->loadHomeView($user_id);
			} else {
				$this->load->view('login');
			}
		} else {
			$this->load->view('login');
		}
	}
	
	function destroySession() {
		$this->session->sess_destroy();
		echo 'destroy';
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


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
