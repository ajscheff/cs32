<?php


class Home extends Controller {


	function Home(){
		parent::Controller();
		$this->load->model('Circles');
		$this->load->model('Messages');
		$this->load->model('Users');
		$this->load->library('session');
		$this->load->helper('url');
	}

	/**
		retrieves data for the cirlce specified by id and username (through POST), then loads
		the circlesinfo view with this data.
	*/
	function loadCircle_id($circle_id) {
		$rawMessageData = $this->Messages->getMessages_circle($circle_id, 0, 10);
		
		$prettyMessageData = array();
		foreach($rawMessageData as $rawMessage) {
			$prettyMessageData[] = $rawMessage->public_name.'@'.$rawMessage->timestamp.': '.$rawMessage->text;
		}
		
		$rawAdminData = $this->Circles->getAdmins($circle_id);
		
		$prettyAdminsData = array();
		foreach($rawAdminData as $rawAdmin) {
			$prettyAdminData[] = $rawAdmin->public_name;
		}
		
		$rawMemberData = $this->Circles->getMembers($circle_id);
		
		$prettyMemberData = array();
		foreach($rawMemberData as $rawMember) {
			$prettyMemberData[] = $rawMember->public_name;
		}
		
		$user_id = $this->session->userdata('user_id');
	
		$data['admins'] = $prettyAdminData;
		$data['members'] = $prettyMemberData;
		$data['messages'] = $prettyMessageData;
		$info = $this->Circles->getInfo($circle_id);
		$data['name'] = $info->name;
		$data['is_admin'] = $this->Users->getUserAdmin($user_id, $circle_id);
		$data['circle_id'] = $circle_id;
		$data['description'] = $info->description;
		$data['email'] = $this->Circles->getEmail($circle_id);
		echo $this->load->view('circleinfo', $data);
	}
	
	function loadCircle() {
		$this->loadCircle_id($_POST['circle_id']);
	}
	
	function addUser() {
		$user_id = $this->Users->getUserID_phone($_POST['phone_number']);
				
		if ($user_id == 0) {
			$user_id = $this->Users->createStubUser($_POST['phone_number']);
		}
		
		$this->Users->addUserToCircle($user_id, $_POST['circle_id'], $_POST['public_name']);
	}
	
	function createCircle() {
		$user_id = $this->session->userdata('user_id');
		$circle_name = $_POST['circle_name'];
		$email = $_POST['email'];
		$email_taken = $this->Circles->getCircleID_email($email);
		$circle_id = $this->Circles->createCircle($user_id, $circle_name, $email, $_POST['privacy'], $_POST['description']);
		//add user who created this circle to the new circle as an admin
		
		redirect('', 'location');
		//redirect('/home/newCircle', 'location');
		//$this->loadHomeView($user_id, $circle_id);
	}
	
	function deleteCircle() {
		$this->Circles->deleteCircle($_POST['circle_id']);
	}
	
	function leaveCircle() {
		$user_id = $this->session->userdata('user_id');
		
		$this->Users->removeUserFromCircle($user_id, $_POST['circle_id']);
	}
	
	function newCircle($user_id, $circle_id) {
		$this->loadHomeView($user_id, $circle_id);
	}
	

	function emailExists() {
		$id = $this->Circles->getCircleID_email($_POST['email']);
		echo $id;
	}
	
		//identical to function in welcome.php.  This should be abstracted eventually
	function loadHomeView(){
	
		$user_id = $this->session->userdata('user_id');
		
		if ($_GET['c_id']) {
			$first_circle = $_GET['c_id'];
		} else {
			$first_circle = 0;
		}
	
		$data['username'] =$this->Users->getUsername($user_id);
		$data['circles'] = $this->Users->getCircles($user_id);
		$data['first_circle'] = $first_circle;
		echo $this->load->view('home', $data);
	}
	
}
