<?php


class Settings extends Controller {

	function Settings(){
		parent::Controller();
		$this->load->model('Users');
		$this->load->library('session');
		$this->load->helper('url');
	}
	
	function loadSettings(){
		$user_id = $this->session->userdata('user_id');
		$username = $this->session->userdata('username');
		$password = $this->session->userdata('password');
		if ($user_id != false && $username != false && $password != false) {
			if ($this->Users->passwordMatches($user_id, $password)) {
				$data['username'] = $username;
				$data['user_id'] = $user_id;
				echo $this->load->view('settings', $data);
			} else {
				redirect('', 'location');
			}
		} else {
			redirect('', 'location');
		}
	}
	
	//this function returns '1' if the password provided by post matches the one on the database
	function checkPassword() {
		$user_id = $this->session->userdata('user_id');
		if($this->Users->passwordMatches($user_id, $_POST['password'])
			echo '1';
		else echo '0';
	}
	
	//this function will change a users password to the password provided by post
	//THIS FUNCTION ASSUMES THAT THE OLD PASSWORD HAS ALREADY BEEN CHECKED!!!
	function changePassword(){
		$user_id = $this->session->userdata('user_id');
		$newPassword = $_POST['password'];	
		$this->Users->changePassword($user_id, $newPassword);
		$session_data = array('password' => $newPassword);
		$this->session->set_userdata($session_data);
		$this->loadSettings();
	}

}
