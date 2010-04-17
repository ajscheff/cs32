<?php

class Welcome extends Controller {

	function Welcome() {
		parent::Controller();	
		$this->load->model('Users');
		}
	
	function index() {
		$this->load->view('login');
		}
	
	
	function createUser(){
		if($this->Users->usernameExists($_POST['username']))
			echo $_POST['username'].' is already taken! Please choose another login.';
		else {
			$this->Users->createUser($_POST['username'], $_POST['password']);
			$data['username'] = $_POST['username'];
			$data['password'] = $_POST['password'];
			echo $this->load->view('home', $data);
			}
		}
	
	function login(){
		if($this->Users->passwordMatches($_POST['username'], $_POST['password'])){
			$data['username'] = $_POST['username'];
			$data['password'] = $_POST['password'];
			echo $this->load->view('home', $data);
			}
		else {
			echo 'You\'re username did not match that password!';
			}
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */