<?php

class Home extends CI_Controller{
		public function __construct()
		{
			parent::__construct();
			
			$this->load->model("models");
			$this->load->helper("url");
			
		}
		
		public function index()
		{

			$this->load->view("welcome");
			echo $this->load->models->get_package();
			echo $this->load->models->get_package_item(1);
						
		}
		public function sign()
		{
			$this->load->view("sign_up");
		}
		public function login()
		{
			$name=$_POST['user'];
			$password=$_POST['password'];
			
			$search_success=$this->models->login($name,$password);
			$data['search_success']=$search_success;
					
					
					if($search_success->num_rows()==1) 
					{
						
						
						$this->load->view("office_page");
					}
			
		}
		public function signup()
		{
			if(isset($_POST['signup']))
			{
				$user=$_POST['user'];
				$fullname=$_POST['fullname'];
				$pasword=$_POST['password'];
				$re_password=$_POST['re_password'];
				$email=$_POST['email'];
				$session1=$_POST['session1'];
				$session2=$_POST['session2'];
				$unit=$_POST['unit'];
				$faculty=$_POST['faculty'];
				$depertment=$_POST['depertment'];
				$date_of_birth=$_POST['date_of_birth'];
				$phone_no=$_POST['phone_no'];
			}
			
		}
		
		
	}

?>