<?php


class Settings extends Controller {

	function loadSettings($username){
		$password = "thisisadummypassword";//$this->Users->getPassword($username);
		$data['username'] = $username;
		$data['password'] = $password;
		echo $this->load->view('settings', $data);
	}
	
	function changePassword(){
		$username = $_POST['username'];
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