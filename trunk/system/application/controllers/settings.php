<?php


class Settings extends Controller {

	function Settings(){
		parent::Controller();
		$this->load->model('Users');
		$this->load->library('session');
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
				$this->load->view('login');
			}
		} else {
			$this->load->view('login');
		}
	}
	
	function changePassword($user_id){
		$oldPassword = $_POST['old_password'];
		if($this->Users->passwordMatches($user_id, $oldPassword)){
			$newPassword = $_POST['new_password'];
			
			$this->Users->changePassword($user_id, $newPassword);
			echo "password changed successfully. no really it is I did it.";
		}
		else{
			echo "password does not match. Please retry entering your password.";
		}
	}
	


}