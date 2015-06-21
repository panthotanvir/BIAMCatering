<?php
class Api extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
	}
	public function index()
	{
		echo "api works";
	}
	public function get($what, $id = null, $id2 = null){
		$this->load->view("empty");
		
		if( $what == "package" ){
			if( $id == null ){
				echo json_encode( $this->load->models->get_all_package() );
			}
			else{
				echo json_encode( $this->load->models->get_package_item($id) );
			}
		}
		
		if( $what == "item" ){
			if( $id == null ){
				echo json_encode( $this->load->models->get_all_item() );
			}
			else{
				echo json_encode( $this->load->models->get_specific_item($id) );
			}
		}
		
		if( $what == "ingredient" ){
			if( $id == null ){
				echo json_encode( $this->load->models->get_all_ingredient() );
			}
			else{
				echo json_encode( $this->load->models->get_specific_ingredient($id) );
			}
		}
		
		if( $what == "item_ingredient" ){
			if( $id == null ){
				echo json_encode( null );
			}
			else{
				echo json_encode( $this->models->get_ingredients_for_item($id) );
			}
		}
		
		if( $what == "ingredient_category" ){
			if( $id == null ){
				echo json_encode( null );
			}
			else{
				echo json_encode( $this->load->models->get_ingredient_from_category($id) );
			}
		}
		
		if( $what == "estimation" ){
			if( $id == null ){
				echo "invalid";
			}
			else{
				echo json_encode( $this->load->models->get_estimation($id) );
			}
		}
		
		if( $what == "menu_item" ){
			if( $id == null ){
				echo json_encode(null);
			}
			else{
				echo json_encode( $this->load->models->get_menu_item($id) );
			}
		}
		
		if( $what == "menu_ingredient" ){
			if( $id == null ){
				echo json_encode(null);
			}
			else{
				echo json_encode( $this->load->models->get_ingredients_for_menu($id) );
			}
		}
		
		if( $what == "menu_ingredient_amount" ){
			if( $id == null OR $id2 == null ){
				echo json_encode(null);
			}
			else{
				echo json_encode( $this->load->models->get_ingredient_amount_for_menu($id, $id2) );
			}
		}
	}
}

?>
