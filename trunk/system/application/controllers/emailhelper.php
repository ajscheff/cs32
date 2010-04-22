<?php

/**
*	
*/
class EmailHelper extends Controller {

	function EmailHelper() {
		parent::Controller();		
	}
	
	function send(){
		$this->load->library('email');

		$this->email->from('test@ombtp.com', 'Test');
		$this->email->to('andyscheff@gmail.com'); 
		
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');	
		
		$this->email->send();
		
		echo $this->email->print_debugger();
	}
	
	function receive(){
	
		$this->load->database();
		$this->load->model('Users');
		$this->load->model('Circles');

		//get the phone number that the email was sent from
		$number = substr($_POST['from'], 0, 10);
		$email = 

		//if the phone number exists in our database
		if ($this->Users->phoneExists($number) {

			if 
		}
		else {
			//phone doesn't exist, send reply?
		}
		
		$this->db->set('to', $_POST['to']);
		$this->db->set('from', $_POST['from']);
		$this->db->set('message', $_POST['text']);
		$this->db->insert('email_test');
		
	}
	
	function test() {
		$this->load->model('Users');
		$this->Users->getPermissions(1, 1);
	}
}
