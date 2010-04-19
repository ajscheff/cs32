<?php

/**
*	
*/
class Email extends Controller {

	function Email() {
		parent::Controller();		
	}
	
	function email(){
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
		
		$this->db->set('to', $_POST['to']);
		$this->db->set('from', $_POST['from']);
		$this->db->set('message', $_POST['text']);
		$this->db->insert('email_test');
		
	}
}