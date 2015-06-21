
<?php
class Store extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
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
		if( isset($_POST['type']) ){
			$temp = $_POST['type'];
		}

		$this->form_validation->set_rules('event_date', 'তারিখ', 'required|callback_date_check');
		$this->form_validation->set_rules('person_name', 'বাজারকারীর নাম', 'required');
		$this->form_validation->set_rules('type', 'type', 'required');
		$this->form_validation->set_rules('ingredient[]', 'List of Ingredients', 'required');
		$this->form_validation->set_rules('quantity[]', 'Quantity', 'required|numeric');
		
		$this->load->view("template/header");
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('store_create');
		}
		else
		{
			$data = array(
				"event_date" => $_POST['event_date'],
				"person_name" => $_POST['person_name'],
				"type" => $_POST['type'],
				"ingredient" => $_POST['ingredient'],
				"quantity" => $_POST['quantity']
			);

			
			
			$datas=$this->models->get_all_ingredient();
			
			$check = true;
			
			foreach($datas as $i){
				for($j = 0; $j < count($data['ingredient']); $j++){
					 
					if($data['ingredient'][$j] == $i['ingredient_id']){
						if($temp == 1){
						}
						else{
							if($i['ingredient_stock'] >= $data['quantity'][$j] ){
							}else{

								$check = false;
							}
						}
					}
				}
			}
			
			if( $check == false ){
				$this->load->view('message', array('message' => 'Input quantity error.'));
			}
			else{
				
				for($j = 0; $j < count($data['ingredient']); $j++){
					if($temp == 1) $change = $data['quantity'][$j];
					else $change = - $data['quantity'][$j];
					$this->models->update_stock($change, $data['ingredient'][$j]);
				}
				$this->models->create_store($data);
				$this->load->view('message', array('message' => 'Ingredient transaction successfull.'));
			}

		}
		
		$this->load->view("template/footer");
	}
	
	public function stock($event_date = null ,$str_id = null ,$type = null)
	{
		
		if( isset($_POST['submit']) ){
			//$this->form_validation->set_rules('event_date', 'তারিখ', 'required');
			$this->form_validation->set_rules('type', 'type', 'required');
			$this->form_validation->set_rules('str_id', 'Ingredient', 'required');
			if($_POST['event_date'] == null ){
			
				$event_date = "0";
				if( isset($_POST['str_id']) )$str_id = $_POST['str_id'];
				if( isset($_POST['type']) )$type = $_POST['type'];
				redirect("store/stock/{$event_date}/{$str_id}/{$type}");
			}
			else redirect("store/stock/{$_POST['event_date']}/{$_POST['str_id']}/{$_POST['type']}");
			
			
		}
		 if($event_date == null && $str_id == null && $type == null){
			
				$event_date = "0";
				$str_id = "all";
				$type = "0";
				redirect("store/stock/{$event_date}/{$str_id}/{$type}");
				
		}
		
		
		$data = array(
				"event_date" => $event_date,
				"ingredient" => $str_id,
				"type" => $type
				
		);
			
		$datas = array(
		"store" => $this->models->get_store_info($data)
			);
		$this->load->view("template/header");
		$this->load->view("view_store", $datas);
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
	public function requisition()
	{
		if( isset($_POST['quantity']) ){
			for($i=0; $i<count($_POST['quantity']); $i++){
				$_POST['quantity'][$i] = $this->convert_number($_POST['quantity'][$i]);
			}
		}
		
		$this->form_validation->set_rules('event_date', 'তারিখ', 'required|callback_date_check');
		$this->form_validation->set_rules('person_name', 'বাজারকারীর নাম', 'required');
		$this->form_validation->set_rules('type', 'type', 'required');
		$this->form_validation->set_rules('ingredient[]', 'List of Ingredients', 'required');
		$this->form_validation->set_rules('quantity[]', 'Quantity', 'required|numeric');
		
		$this->load->view("template/header");
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('create_requisition');
		}
		else
		{
			$data = array(
				"event_date" => $_POST['event_date'],
				"person_name" => $_POST['person_name'],
				"type" => $_POST['type'],
				"ingredient" => $_POST['ingredient'],
				"quantity" => $_POST['quantity']
			);
			$this->models->create_store($data);
			$this->load->view('message', array('message' => 'Item added successfully.'));
		}
		
		$this->load->view("template/footer");
		
	}
	public function view_stock(){
		$data = array(
			"stocks" => $this->models->get_stock()
		);
		$this->load->view("template/header");
		$this->load->view("view_store_show", $data);
		$this->load->view("template/footer");
	}
}
?>

