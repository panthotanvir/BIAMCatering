<?php
class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function login(){
		if( $this->models->is_logged_in() == TRUE ) redirect("");
		
		$this->form_validation->set_rules('user_name', 'User Name', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ( $this->form_validation->run() == TRUE )
		{
			$user_name = $_POST['user_name'];
			$password = $_POST['password'];
			
			if( $this->models->login($user_name, $password) == TRUE ){
				redirect("");
			}
		}
		$this->load->view("template/login_header");
		$this->load->view('user_login');
		$this->load->view("template/footer");
		
	}
	public function logout(){
		$this->models->logout();
		redirect("");
	}
	public function view(){
		if( $this->models->is_logged_in() == FALSE ) redirect("");
		
		$data = array(
			"users" => $this->models->get_all_user()
			);
		$this->load->view("template/header");
		$this->load->view('user_view', $data);
		$this->load->view("template/footer");
	}
	public function create(){
		if( $this->models->is_logged_in() == FALSE ) redirect("");
		
		$this->form_validation->set_rules('user_name', 'User Name', 'required|is_unique[user.user_name]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('type', 'type', 'required');
		
		if ( $this->form_validation->run() == TRUE )
		{
			$user_name = $_POST['user_name'];
			$password = $_POST['password'];
			$type = $_POST['type'];
			
			$this->models->create_user($user_name, $password, $type);
			$this->load->view("template/header");
			$this->load->view('message', array("message"=>"User created successfully."));
			$this->load->view("template/footer");
		}
		else{
			$this->load->view("template/header");
			$this->load->view('user_create');
			$this->load->view("template/footer");
		}
	}
	public function edit($user_id = null){
		if( $this->models->is_logged_in() == FALSE ) redirect("");
		
		if($user_id == null) $user_id = $this->session->userdata('user_id');
		else if( $this->models->is_admin() == FALSE ) redirect("");
		
		
		
		$this->form_validation->set_rules('user_name', 'User Name', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('type', 'type', 'required');
		
		if ( $this->form_validation->run() == TRUE )
		{
			$data = array(
				"user_id" => $user_id,
				"user_name" => $_POST['user_name'],
				"password" => $_POST['password'],
				"type" => $_POST['type']
			);
			
			$this->models->update_user($data);
			
			$this->load->view("template/header");
			$this->load->view('message', array("message"=>"User edited successfully."));
			$this->load->view("template/footer");
		}
		else{
			$this->load->view("template/header");
			$this->load->view( 'user_edit', $this->models->get_specific_user($user_id) );
			$this->load->view("template/footer");
		}
	}
	
	public function delete($user_id){
		$this->load->view("template/header");
		if( $user_id == $this->session->userdata('user_id') ){
			$this->load->view('error', array("error"=>"You can't delete yourself."));
		}
		else{
			$this->models->delete_user($user_id);
			$this->load->view('message', array("message"=>"User deleted successfully."));
		}
		$this->load->view("template/footer");
	}
}
?>

