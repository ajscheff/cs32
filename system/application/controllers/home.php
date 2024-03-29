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
		retrieves data for the circle specified by id, then loads
		the circlesinfo view with this data.
	*/
	function loadCircle_id($circle_id) {
		$rawMessageData = $this->Messages->getMessages_circle($circle_id, 0, 10);
		
		$prettyMessageData = array();
		foreach($rawMessageData as $rawMessage) {
			$prettyMessageData[] = $rawMessage->public_name.'@'.$rawMessage->timestamp.': '.$rawMessage->text;
		}
		
		$rawAdminData = $this->Circles->getAdmins($circle_id);
		
		$prettyAdminData = array();
		foreach($rawAdminData as $rawAdmin) {
			$prettyAdminData[] = array('public_name' => $rawAdmin->public_name, 'user_id' => $rawAdmin->user_id);
		}
		
		
		$rawMemberData = $this->Circles->getMembers($circle_id);
		
		$prettyMemberData = array();
		foreach($rawMemberData as $rawMember) {
			$prettyMemberData[] = array('public_name' => $rawMember->public_name, 'user_id' => $rawMember->user_id);
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
	
	function setUserSettings() {
		$this->Users->setUserPrivileges($_POST['user_id'], $_POST['circle_id'], $_POST['privileges']);
	}
	
	function loadCircle() {
		$this->loadCircle_id($_POST['circle_id']);
	}
	
	function addUser() {
		$user_id = $this->Users->getUserID_phone($_POST['phone_number']);
		$circle_id = $_POST['circle_id'];
	
		if ($user_id == 0) {
			$phone_number = $_POST['phone_number'];
			$user_id = $this->Users->createStubUser($phone_number);
			
				//gather data about the user who added the new user
			$adders_id = $this->session->userdata('user_id');
			$adders_pub_name = $this->Users->getPublicName($adders_id, $user_id);
			$adders_phone = $this->Users->getPhone($adders_id);
			
				//inform new user that they have been invited to mobi
			$local_reply = "$adders_pub_name with number $adders_phone has invited you to Mobi. Reply with '#upgrademe <myusername>' to make a full account.  Go to mobi.com to learn more.";
			$temp_prov_id = $this->Users->internetLookupProvider($phone_number);
			if($temp_prov_id != 0){
				$temp_gateway = $this->Users->getProvider($temp_prov_id);
				$this->Messages->send("admin@ombtp.com", $phone_number.'@'.$temp_gateway, $local_reply);
			}
		}
		else {
			if ($this->Circles->isMember($user_id, $circle_id)){
				echo '0';
			}
			else {
				$this->Users->addUserToCircle($user_id, $circle_id, $_POST['public_name'], $_POST['admin'], $_POST['privileges']);
				$adders_id = $this->session->userdata('user_id');
				$adders_pub_name = $this->Users->getPublicName($adders_id, $circle_id);
				$adders_phone = $this->Users->getPhone($adders_id);
				$circle_email = $this->Circles->getEmail($circle_id);
				$local_reply = "$adders_pub_name, with number $adders_phone, has added you to circle $circle_email.";
				$phone_number = $this->Users->getPhone($user_id);
				$temp_prov_id = $this->Users->internetLookupProvider($phone_number);
				if($temp_prov_id != 0){
					$temp_gateway = $this->Users->getProvider($temp_prov_id);
					$this->Messages->send("admin@ombtp.com", $phone_number.'@'.$temp_gateway, $local_reply);
				}
				$this->loadCircle_id($circle_id);
				echo '1';
			}
		}
	}
	
	function createCircle() {
		$user_id = $this->session->userdata('user_id');
		$circle_name = $_POST['circle_name'];
		$email = $_POST['email'];
		$email_taken = $this->Circles->getCircleID_email($email);
		$circle_id = $this->Circles->createCircle($user_id, $circle_name, $email, $_POST['description']);
		
		redirect('/home/loadHomeView/'.$circle_id);
	}
	
	function deleteCircle() {
		$this->Circles->deleteCircle($_POST['circle_id']);
	}
	
	function leaveCircle() {
		$user_id = $this->session->userdata('user_id');
		$this->Users->removeUserFromCircle($user_id, $_POST['circle_id']);
	}
	

	function emailExists() {
		$id = $this->Circles->getCircleID_email($_POST['email']);
		echo $id;
	}
	
	function setUserAdmin() {
		$this->Users->setUserAdmin($_POST['user_id'], $_POST['circle_id'], $_POST['admin']);
	}
	
		//identical to function in welcome.php.  This should be abstracted eventually
	function loadHomeView($circle_id = 0){
	
		$user_id = $this->session->userdata('user_id');
		
		if ($this->Circles->isMember($user_id, $circle_id) && $circle_id != 0) {
			$data['first_circle'] = $circle_id;	
		}
		else {
			$data['first_circle'] = 0;
		}
		
		$data['username'] =$this->Users->getUsername($user_id);
		$data['circles'] = $this->Users->getCircles($user_id);
		echo $this->load->view('home', $data);
		
	}
	
	function removeUserFromCircle() {
		$circle_id = $_POST['circle_id'];
		$user_id = $_POST['user_id'];
		$this->Users->removeUserFromCircle($user_id, $circle_id);
		$this->loadCircle_id($circle_id);
	}
	
}
