<?php
class Custom extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
	}
	public function home(){
		$this->load->view("template/header");
		$this->load->view("home");
		$this->load->view("template/footer");
	}
}

?>

