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
		$this->load->helper('url');
	}
	
	function index() {
		$user_id = $this->session->userdata('user_id');
		$username = $this->session->userdata('username');
		$password = $this->session->userdata('password');
		if ($user_id != false && $username != false && $password != false) {
			if ($this->Users->passwordMatches($user_id, $password)) {
				$this->loadHomeView();
			} else {
				$this->load->view('login');
			}
		} else {
			$this->load->view('login');
		}
	}
	
	function logout() {
		$this->session->sess_destroy();
		redirect('', 'location');
	}
	
	function signup(){
		$username = $_POST['username'];
		$user_id = $this->Users->getUserID_username($username);
		
		$stripped_phone = preg_replace("[^0-9]", "", $_POST['phone_number']);
		
		if($user_id == 0){
			$user_id = $this->Users->createFullUser($username, $_POST['password'], $stripped_phone, $_POST['public_name']);
			$session_data = array(
				'username' => $username,
				'password' => $_POST['password'],
				'user_id' => $user_id
			);
			$this->session->set_userdata($session_data);
			$this->loadHomeView();
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
				redirect('', 'location');
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
	function usernameExists(){
		$username = $_POST['username'];
		$id = $this->Users->getUserID_username($username);
		echo 'id'.$id;
	}
	
	function loadHomeView($circle_id = 0){
	
		$user_id = $this->session->userdata('user_id');
		
		$data['username'] =$this->Users->getUsername($user_id);
		$data['circles'] = $this->Users->getCircles($user_id);
		$data['first_circle'] = $circle_id;
		echo $this->load->view('home', $data);
	}
	
	function quickTest() {
		$result = $this->Users->getUserAdmin(1, 1);
		
		if ($result == 1) echo 'the user is an admin';
		else echo 'no';
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
