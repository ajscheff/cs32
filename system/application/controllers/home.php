<?php


class Home extends Controller {


	function Home(){
		parent::Controller();
		$this->load->model('Circles');
	
	
	}

	/**
	
	
	*/
	function loadCircle(){
		$username = $_POST['username'];
		$circle_id = $POST['circle_id'];
		
		echo $this->load->view('circlesinfo', $data);
	
	}
}