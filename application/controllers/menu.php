<?php
class Menu extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function date_check($date)
	{
		if ( strtotime($date) < strtotime( date("Y-m-d") )  )
		{
			$this->form_validation->set_message('date_check', 'The date can not be in the past.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	public function create()
	{
		
		$this->form_validation->set_rules('party_name', 'প্রতিষ্ঠান/কোর্সের নাম', 'required');
		$this->form_validation->set_rules('event_date', 'তারিখ', 'required|callback_date_check');
		$this->form_validation->set_rules('event_time', 'সময়', 'required');
		$this->form_validation->set_rules('num_person', 'অতিথি সংখ্যা', 'required|integer|greater_than[0]');
		$this->form_validation->set_rules('menu_price', 'দাম', 'required|numeric|greater_than[0]');
		$this->form_validation->set_rules('item[]', 'খাবারের তালিকা', 'required');
		$this->form_validation->set_rules('people[]', 'Number of People', 'required|greater_than[0]');
		$this->form_validation->set_rules('quantity[]', 'Quantity', 'required|greater_than[0]');
		
		$this->load->view("template/header");
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('create_menu');
		}
		else
		{
			$data = array(
				"party_name" => $_POST['party_name'],
				"event_date" => $_POST['event_date'],
				"event_time" => $_POST['event_time'],
				"num_person" => $_POST['num_person'],
				"menu_price" => $_POST['menu_price'],
				"item" => $_POST['item'],
				"quantity" => $_POST['quantity'],
				"people" => $_POST['people']
			);
			$this->models->create_menu($data);
			$this->models->reset_price($data["event_date"]);
			$this->models->reset_extra($data["event_date"]);
			$this->load->view('message', array('message' => 'Menu created successfully.'));
		}
		
		$this->load->view("template/footer");
	}
	public function edit($menu_id)
	{
		
		$this->form_validation->set_rules('party_name', 'প্রতিষ্ঠান/কোর্সের নাম', 'required');
		$this->form_validation->set_rules('event_date', 'তারিখ', 'required|callback_date_check');
		$this->form_validation->set_rules('event_time', 'সময়', 'required');
		$this->form_validation->set_rules('num_person', 'অতিথি সংখ্যা', 'required|integer|greater_than[0]');
		$this->form_validation->set_rules('menu_price', 'দাম', 'required|numeric|greater_than[0]');
		$this->form_validation->set_rules('item[]', 'খাবারের তালিকা', 'required');
		$this->form_validation->set_rules('people[]', 'Number of People', 'required|greater_than[0]');
		$this->form_validation->set_rules('quantity[]', 'Quantity', 'required|greater_than[0]');
		
		$this->load->view("template/header");
		if ($this->form_validation->run() == FALSE)
		{
			$data = array(
				"menu_id" => $menu_id,
				"menu_data" => $this->models->get_specific_menu($menu_id)
			);
			$this->load->view('menu_edit', $data);
		}
		else
		{
			$data = array(
				"menu_id" => $menu_id,
				"party_name" => $_POST['party_name'],
				"event_date" => $_POST['event_date'],
				"event_time" => $_POST['event_time'],
				"num_person" => $_POST['num_person'],
				"menu_price" => $_POST['menu_price'],
				"item" => $_POST['item'],
				"quantity" => $_POST['quantity'],
				"people" => $_POST['people']
			);
			$this->models->menu_estimation_reset($menu_id);
			$this->models->update_menu($data);
			$this->models->reset_price($data["event_date"]);
			$this->models->reset_extra($data["event_date"]);
			$this->load->view('message', array('message' => 'Menu edited successfully.'));
		}
		
		$this->load->view("template/footer");
	}
	public function delete($menu_id)
	{
		$data = $this->models->get_specific_menu($menu_id);
		
		$this->models->reset_price($data["event_date"]);
		$this->models->reset_extra($data["event_date"]);
		
		$this->models->delete_menu($menu_id);
		
		$this->load->view("template/header");
		$this->load->view('message', array('message' => 'Menu DELETED.'));
		$this->load->view("template/footer");
	}
	public function view_by_date($date = null)
	{
		if( isset($_POST['submit']) ) redirect("menu/view_by_date/{$_POST['event_date']}");
		if( $date == null ) $date = date("Y-m-d");
		$data = array(
			"date" => $date,
			"menus" => $this->models->get_all_menu($date)
		);
		$this->load->view("template/header");
		$this->load->view("view_menu_list", $data);
		$this->load->view("template/footer");
	}
	public function view($menu_id)
	{
		$data = array(
			"menu_data" => $this->models->get_specific_menu($menu_id),
			"menu_item_data" => $this->models->get_menu_item($menu_id),
			"menu_estimation_data" => $this->models->get_estimation_with_ingredients($menu_id),
			"menu_cost" => $this->models->get_menu_cost($menu_id)
		);
		$this->load->view("template/header");
		$this->load->view("view_menu", $data);
		$this->load->view("template/footer");
	}
	public function receipt($menu_id)
	{
		$data = array(
			"menu_data" => $this->models->get_specific_menu($menu_id),
			"menu_item_data" => $this->models->get_menu_item($menu_id),
			"menu_estimation_data" => $this->models->get_estimation_with_ingredients($menu_id),
			"menu_cost" => $this->models->get_menu_cost($menu_id)
		);
		$this->load->view("template/header");
		$this->load->view("view_menu", $data);
		$this->load->view("template/footer");
	}
	public function estimate($menu_id){
		if( $this->models->is_menu_estimation_done($menu_id) == TRUE ) redirect("menu/view/{$menu_id}");
		
		$this->form_validation->set_rules('ingredient_id[]', '', 'required|integer');
		$this->form_validation->set_rules('amount[]', 'Amount', 'required|numeric|greater_than[0]');
		
		$this->load->view("template/header");
		if ($this->form_validation->run() == FALSE)
		{
			$data = array(
				"menu_id" => $menu_id,
				"menu_data" => $this->models->get_specific_menu($menu_id),
				"menu_estimate" => $this->models->get_ingredients_for_menu($menu_id), 
				"menu_item_data" => $this->models->get_menu_item($menu_id)
			);
			
			$this->load->view("create_menu_estimate", $data);
		}
		else
		{
			$data = array(
				"menu_id" => $menu_id,
				"menu_data" => $this->models->get_specific_menu($menu_id),
				"ingredient" => $_POST["ingredient_id"],
				"amount" => $_POST["amount"]
				
			);
			$this->models->create_estimation($data);
			$this->models->menu_estimation_done($menu_id);
			$this->models->reset_price($data["menu_data"]["event_date"]);
			$this->models->reset_extra($data["menu_data"]["event_date"]);
			$this->load->view('message', array('message' => 'Menu estimated successfully.'));
		}
		$this->load->view("template/footer");
	}
}
?>
