<?php
class Ingredient extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
	}
	public function convert_number($str){
		$c = array( '০' => '0', '১' => '1',
			'২' => '2', '৩' => '3',
			'৪' => '4', '৫' => '5',
			'৬' => '6', '৭' => '7',
			'৮' => '8', '৯' => '9'
		);
		return strtr($str, $c);
	}
	public function create()
	{
		if( isset($_POST['ingredient_price']) ){
			$_POST['ingredient_price'] = $this->convert_number($_POST['ingredient_price']);
		}
		
		$this->form_validation->set_rules('ingredient_name', 'Ingredient Name', 'required|is_unique[ingredient.ingredient_name]');
		$this->form_validation->set_rules('ingredient_unit', 'Ingredient Unit', 'required');
		$this->form_validation->set_rules('ingredient_price', 'Ingredient Price', 'required|numeric|greater_than[0]');
		$this->form_validation->set_rules('ingredient_category', 'Ingredient Category', 'required');
		
		$this->load->view("template/header");
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('ingredient_create');
		}
		else
		{
			$data = array(
				"ingredient_name" => $_POST['ingredient_name'],
				"ingredient_unit" => $_POST['ingredient_unit'],
				"ingredient_price" => $_POST['ingredient_price'],
				"ingredient_category" => $_POST['ingredient_category']
			);
			$this->models->create_ingredient($data);
			$this->load->view('message', array('message' => 'Ingredient created successfully.'));
		}
		
		$this->load->view("template/footer");
	}
	public function edit($ingredient_id)
	{
		if( isset($_POST['ingredient_price']) ){
			$_POST['ingredient_price'] = $this->convert_number($_POST['ingredient_price']);
		}
		
		$this->form_validation->set_rules('ingredient_name', 'Ingredient Name', 'required');
		$this->form_validation->set_rules('ingredient_unit', 'Ingredient Unit', 'required');
		$this->form_validation->set_rules('ingredient_price', 'Ingredient Price', 'required|numeric|greater_than[0]');
		$this->form_validation->set_rules('ingredient_category', 'Ingredient Category', 'required');
		
		$this->load->view("template/header");
		if ($this->form_validation->run() == FALSE)
		{
			$data = array(
				"ingredient_id" => $ingredient_id,
				"ingredient_data" => $this->models->get_specific_ingredient($ingredient_id)
			);
			$this->load->view('ingredient_edit', $data);
		}
		else
		{
			$data = array(
				"ingredient_id" => $ingredient_id,
				"ingredient_name" => $_POST['ingredient_name'],
				"ingredient_unit" => $_POST['ingredient_unit'],
				"ingredient_price" => $_POST['ingredient_price'],
				"ingredient_category" => $_POST['ingredient_category']
			);
			$this->models->update_ingredient($data);
			$this->load->view('message', array('message' => 'Ingredient updated successfully.'));
		}
		
		$this->load->view("template/footer");
	}
	public function view()
	{
		$data = array(
			"ingredients" => $this->models->get_all_ingredient()
		);
		$this->load->view("template/header");
		$this->load->view("ingredient_view", $data);
		$this->load->view("template/footer");
	}
	public function delete($ingredient_id)
	{
		$this->models->delete_ingredient($ingredient_id);
		
		$this->load->view("template/header");
		$this->load->view('message', array('message' => 'Ingredient deleted successfully.'));
		$this->load->view("template/footer");
	}
}
?>

