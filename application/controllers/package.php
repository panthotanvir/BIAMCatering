<?php
class Package extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function create()
	{
		$this->form_validation->set_rules('package_name', 'প্যাকেজের নাম', 'required');
		$this->form_validation->set_rules('package_price', 'দাম', 'required|numeric|greater_than[0]');
		$this->form_validation->set_rules('item', 'List of Items', 'required');
		
		$this->load->view("template/header");
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('create_package');
		}
		else
		{
			$data = array(
				"package_name" => $_POST['package_name'],
				"package_price" => $_POST['package_price'],
				"item" => array_unique($_POST['item'])
			);
			$this->models->create_package($data);
			$this->load->view('message', array('message' => 'Package added successfully.'));
		}
		
		$this->load->view("template/footer");
	}
	public function view($package_id)
	{
		$data = array(
			"package_data" => $this->models->get_specific_package($package_id),
			"package_item_data" => $this->models->get_package_item($package_id)
		);
		$this->load->view("template/header");
		$this->load->view("view_package", $data);
		$this->load->view("template/footer");
	}
	public function all()
	{
		$data = array(
			"packages" => $this->models->get_all_package()
		);
		$this->load->view("template/header");
		$this->load->view("view_package_all", $data);
		$this->load->view("template/footer");
	}
}
?>
