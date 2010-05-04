<?php


class Settings extends Controller {

	function Settings(){
		parent::Controller();
		$this->load->model('Users');
		$this->load->library('session');
	}
	
	function loadSettings(){
		/*$user_id = $this->session->userdata('user_id');
		$username = $this->session->userdata('username');
		$password = $this->sesson->userdata('password');
		if ($this->Users->passwordMatches($username, $password) {
			$data['username'] = $username;
			echo $this->load->view('settings', $data);
		} else {*/
			$this->load->view('login');
		//}
	}
	
	function changePassword($username){
		$username = $username;
		$oldPassword = $_POST['old_password'];
		if($this->Users->passwordMatches($username, $oldPassword)){
			$newPassword = $_POST['new_password'];
			//code to change password in Model
			echo "password changed successfully";
		}
		else{
			echo "password does not match. Please retry entering your password.";
		}
	}
	


}
