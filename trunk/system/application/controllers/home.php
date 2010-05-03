<?php


class Home extends Controller {


	function Home(){
		parent::Controller();
		$this->load->model('Circles');
		$this->load->model('Messages');
	
	
	}

	/**
		retrieves data for the cirlce specified by id and username (through POST), then loads
		the circlesinfo view with this data.
	*/
	function loadCircle(){
		$circle_id = $_POST['circle_id'];
		$data['admins'] = $this->Circles->getAdmins($circle_id);
		$data['messages'] = $this->Messages->getMessages_circle($circle_id, 0, 10);
		$info = $this->Circles->getInfo($circle_id);
		$data['name'] = $info->name;
		$data['description'] = $info->description;
		echo $this->load->view('circleinfo', $data);
	
	}
}