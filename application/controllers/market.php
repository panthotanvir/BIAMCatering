<?php
class Market extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
	}
	
	public function status($date = null){
		if( isset($_POST['submitdate']) ) redirect("market/status/{$_POST['event_date']}");
		if( $date == null ) $date = date("Y-m-d");
		
		$data = array(
			"date" => $date
		);
		
		$this->load->view("template/header");
		$this->load->view("status", $data);
		$this->load->view("template/footer");
	}
	
	public function set_price($date = null){
		if( isset($_POST['submitdate']) ) redirect("market/set_price/{$_POST['event_date']}");
		if( $date == null ) $date = date("Y-m-d");
		
		$this->form_validation->set_rules('ingredient[]', 'Ingredents List', 'required');
		$this->form_validation->set_rules('price[]', 'Price', 'required|numeric|greater_than[0]');
		
		if ( $this->models->is_all_menu_estimated($date) == FALSE || $this->form_validation->run() == FALSE)
		{
			$data = array(
				"date" => $date,
				"data" => $this->models->get_ingredients_market($date)
			);
			$this->load->view("template/header");
			$this->load->view("market_price", $data);
			$this->load->view("template/footer");
		}
		else
		{
			$data = array(
				"date" => $date,
				"ingredient" => $_POST['ingredient'],
				"price" => $_POST['price']
			);
			$this->models->update_market($data);
			$this->load->view("template/header");
			$this->load->view("message", array("message"=>"Price updated successfully."));
			$this->load->view("template/footer");
		}
	}
	
	
	public function bazar($date = null){
		if( isset($_POST['submit']) ) redirect("market/bazar/{$_POST['event_date']}");
		if( $date == null ) $date = date("Y-m-d");
		$data = array(
			"date" => $date,
			"market" => $this->models->get_market($date),
			"extra" => $this->models->get_extra($date)
		);
		$this->load->view("template/header");
		$this->load->view("bazar", $data);
		$this->load->view("template/footer");
	}
	
	public function accounting($dateStart = null, $dateEnd = null){
		if( isset($_POST['submitdate']) ){
			redirect("market/accounting/{$_POST['dateStart']}/{$_POST['dateEnd']}");
		}

		if( $dateStart == null OR $dateEnd == null ){
			$dateStart = date("Y-m-d");
			$dateEnd = date("Y-m-d");
			redirect("market/accounting/{$dateStart}/{$dateEnd}");
		}
		
		$error = $this->models->is_there_error_in_range($dateStart, $dateEnd);
		
		$data = array(
			"dateStart" => $dateStart,
			"dateEnd" => $dateEnd,
			"error" => $error
		);
		
		if($error == NULL){
			$data["data"] =  $this->models->get_accounting($dateStart, $dateEnd);
		}
		
		$this->load->view("template/header");
		$this->load->view("accounting", $data);
		$this->load->view("template/footer");
	}
	
	public function extra($date = null){
		if( isset($_POST['submitdate']) ) redirect("market/extra/{$_POST['event_date']}");
		if( $date == null ) $date = date("Y-m-d");
		
		$this->form_validation->set_rules('ingredient[]', 'Ingredents List', '');
		$this->form_validation->set_rules('amount[]', 'Amount', 'numeric|greater_than[0]');
		
		if ( $this->models->is_all_menu_estimated($date) == FALSE || $this->form_validation->run() == FALSE)
		{
			$data = array(
				"date" => $date,
				"people" => $this->models->get_people($date)
			);
			$this->load->view("template/header");
			$this->load->view("extra", $data);
			$this->load->view("template/footer");
		}
		else
		{
			$data = array(
				"date" => $date,
				"ingredient" => $_POST['ingredient'],
				"amount" => $_POST['amount']
			);
			
			$this->models->update_extra($data);
			
			$this->models->reset_price($date);
			
			$this->load->view("template/header");
			$this->load->view("message", array("message"=>"Miscellaneous Ingredient(s) updated successfully."));
			$this->load->view("template/footer");
		}
	}
	
	public function reset_extra($date){
		$this->models->reset_price($date);
		$this->models->reset_extra($date);
		
		$this->load->view("template/header");
		$this->load->view("message", array("message"=>"Miscellaneous Ingredient(s) RESET done."));
		$this->load->view("template/footer");
	}
	
	public function reset_price($date){
		$this->models->reset_price($date);
		
		$this->load->view("template/header");
		$this->load->view("message", array("message"=>"Price RESET done."));
		$this->load->view("template/footer");
	}
}
?>


