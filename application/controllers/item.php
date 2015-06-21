<?php
class Item extends CI_Controller
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
	public function is_array_unique($a){
		var_dump($a);
		die();
		$b = array_unique($a);
		if( count($a) == count($b) ) return TRUE;
		else{
			$this->form_validation->set_message('is_array_unique', 'The %s should be unique.');
			return FALSE;
		}
	}
	public function create()
	{
		
		if( isset($_POST['quantity']) ){
			for($i=0; $i<count($_POST['quantity']); $i++){
				$_POST['quantity'][$i] = $this->convert_number($_POST['quantity'][$i]);
			}
		}
		
		if( isset($_POST['people']) ) $_POST['people'] = $this->convert_number($_POST['people']);
		
		$this->form_validation->set_rules('item_name', 'Item Name', 'required|is_unique[item.item_name]');
		$this->form_validation->set_rules('people', 'Number of People', 'required|integer');
		$this->form_validation->set_rules('ingredient[]', 'List of Ingredients', 'required');
		$this->form_validation->set_rules('quantity[]', 'Quantity', 'required|numeric');
		
		$this->load->view("template/header");
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('item_create');
		}
		else
		{
			$data = array(
				"item_name" => $_POST['item_name'],
				"people" => $_POST['people'],
				"ingredient" => $_POST['ingredient'],
				"quantity" => $_POST['quantity']
			);
			$this->models->create_item($data);
			$this->load->view('message', array('message' => 'Item added successfully.'));
		}
		
		$this->load->view("template/footer");
	}
	public function view()
	{
		$data = array(
			"items" => $this->models->get_all_item()
		);
		$this->load->view("template/header");
		$this->load->view("item_view", $data);
		$this->load->view("template/footer");
	}
	public function individual($item_id)
	{
		$data = array(
			"item_data" => $this->models->get_specific_item($item_id),
			"ingredients" => $this->models->get_ingredients_for_item($item_id)
		);
		$this->load->view("template/header");
		$this->load->view("item_view_individual", $data);
		$this->load->view("template/footer");
	}
	public function delete($item_id)
	{
		$this->models->delete_item($item_id);
		$this->load->view("template/header");
		$this->load->view('message', array('message' => 'Item deleted successfully.'));
		$this->load->view("template/footer");
	}
	public function edit($item_id)
	{
		if( $this->models->is_admin() == FALSE ){
			redirect('404');
		}
		
		if( isset($_POST['quantity']) ){
			for($i=0; $i<count($_POST['quantity']); $i++){
				$_POST['quantity'][$i] = $this->convert_number($_POST['quantity'][$i]);
			}
		}
		
		if( isset($_POST['people']) ) $_POST['people'] = $this->convert_number($_POST['people']);

		$this->form_validation->set_rules('item_name', 'Item_name', 'required');
		$this->form_validation->set_rules('people', 'Number of People', 'required|integer');
		$this->form_validation->set_rules('ingredient[]', 'List of Ingredients', 'required');
		$this->form_validation->set_rules('quantity[]', 'Quantity', 'required|numeric');
		
		$this->load->view("template/header");
		if ($this->form_validation->run() == FALSE)
		{
			$data = array(
				"item_id" => $item_id,
				"item_data" => $this->models->get_specific_item($item_id),
				"ingredients" => $this->models->get_ingredients_for_item($item_id)
			);
			$this->load->view('item_edit', $data);
		}
		else
		{
			$data = array(
				"item_id" => $item_id,
				"item_name" => $_POST['item_name'],
				"people" => $_POST['people'],
				"ingredient" => $_POST['ingredient'],
				"quantity" => $_POST['quantity']
			);
			$this->models->update_item($data);
			$this->load->view('message', array('message' => 'Item edited successfully.'));
		}
		
		$this->load->view("template/footer");
	}
	public function all()
	{
		$this->load->view("template/header");
		$items = $this->models->get_all_item();
		foreach($items as $i){
			$item_id = $i['item_id'];
			$data = array(
			"item_data" => $this->models->get_specific_item($item_id),
			"ingredients" => $this->models->get_ingredients_for_item($item_id)
			);
			$this->load->view("item_all", $data);
		}
		$this->load->view("template/footer");
	}
}
?>

