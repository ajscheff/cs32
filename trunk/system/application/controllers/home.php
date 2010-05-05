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
		echo 'entered loadCircle()';
		$circle_id = $_POST['circle_id'];
		$data['admins'] = $this->Circles->getAdmins($circle_id);
		$data['messages'] = $this->Messages->getMessages_circle($circle_id, 0, 10);
		$info = $this->Circles->getInfo($circle_id);
		$data['name'] = $info->name;
		$data['description'] = $info->description;
		echo $this->load->view('circleinfo', $data);
	}
	
	function createCircle(){
		echo 'entered createCircle()';
		$user_id = $this->session->userdata('user_id');
		$circle_name = $_POST['circle_name'];
		$email = $_POST['email'];
		$email_taken = $this->Circles->getCircleID_email($email);
		echo 'line0';
		if($email_taken == 0){
			$circle_id = $this->Circles->createCircle($circle_name, $email, $_POST['privacy'], $_POST['description']);
				//add user who created this circle to the new circle as an admin
				
			$preferred_name = $this->Users->getPreferredName($user_id); //get preferred name of user
			
			$this->Users->addUserToCircle($user_id, $circle_id, $preferred_name, 1); //default reply-all
			$this->loadHomeView($user_id, $circle_id);
			echo 'line1';
		}
		else{
			$this->loadHomeView($user_id);
			echo 'line1.1';
		
		}
		
	
	
	}
		//identical to function in welcome.php.  This should be abstracted eventually
	function loadHomeView($user_id, $circle_id = 0;){
		$data['username'] =$this->Users->getUsername($user_id);
		$data['circles'] = $this->Users->getCircles($user_id);
		$data['first_circle'] = $circle_id;
		echo $this->load->view('home', $data);
	}
	
}
