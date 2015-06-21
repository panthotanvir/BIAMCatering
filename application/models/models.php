<?php
class Models extends CI_Model{
		public function __construct()
		{
			parent::__construct();
		}
		public function create_package($data){
			$query = "INSERT INTO package (package_name, package_price)
			VALUES ( '{$data['package_name']}', '{$data['package_price']}' )";
			$result = $this->db->query($query);
			$package_id = $this->db->insert_id();
			foreach( $data['item'] as $item_id ){
				$query = "INSERT INTO package_item (package_id, item_id) VALUES ('{$package_id}', '{$item_id}')";
				$result = $this->db->query($query);
			}
		}
		public function get_all_package(){
			$query = "SELECT * FROM package";
			$result = $this->db->query($query);
			return $result->result_array();
		}
		public function get_specific_package($package_id){
			$query = "SELECT * FROM package WHERE package_id = '{$package_id}'";
			$result = $this->db->query($query);
			return $result->result_array()[0];
		}
		public function get_package_item($package_id){
			$query = "SELECT * FROM  package_item, item WHERE package_item.package_id = "
				.$package_id.
				" AND package_item.item_id = item.item_id";
			$result = $this->db->query($query);
			return $result->result_array();
		}
		public function delete_item($item_id){
			$query = "DELETE FROM item WHERE item_id = '{$item_id}'";
			$result = $this->db->query($query);
		}
		public function create_item($data){
			$query = "INSERT INTO item (item_name) VALUES ( '{$data['item_name']}' )";
			$result = $this->db->query($query);
			$item_id = $this->db->insert_id();
			for($i = 0; $i<count($data['ingredient']); $i++){
				$query = "INSERT INTO item_ingredient (item_id, ingredient_id, people, quantity) VALUES ('{$item_id}', '{$data['ingredient'][$i]}', '{$data['people']}', '{$data['quantity'][$i]}')";
				$result = $this->db->query($query);
			}
		}
		public function update_item($data){
			$item_id = $data['item_id'];
			
			$query = "UPDATE item SET item_name = '{$data['item_name']}' WHERE item_id = '{$item_id}'";
			$result = $this->db->query($query);
			
			$query = "DELETE FROM item_ingredient WHERE item_id = '{$item_id}'";
			
			$result = $this->db->query($query);
			for($i = 0; $i<count($data['ingredient']); $i++){
				$query = "INSERT INTO item_ingredient (item_id, ingredient_id, people, quantity) VALUES ('{$item_id}', '{$data['ingredient'][$i]}', '{$data['people']}', '{$data['quantity'][$i]}')";
				$result = $this->db->query($query);
			}
		}
		public function get_all_item(){
			$query = "SELECT * FROM item";
			$result = $this->db->query($query);
			return $result->result_array();
		}
		public function get_specific_item($item_id){
			$query = "SELECT * FROM  item WHERE item_id = "
				.$item_id.
				"";
			$result = $this->db->query($query);
			return $result->result_array()[0];
		}
		
		public function create_menu($data){
			$query = "INSERT INTO menu (party_name, event_date, event_time, num_person, menu_price)
			VALUES ( '{$data['party_name']}', '{$data['event_date']}', '{$data['event_time']}', '{$data['num_person']}', '{$data['menu_price']}' )";
			$result = $this->db->query($query);
			$menu_id = $this->db->insert_id();
			//foreach( $data['item'] as $item_id ){
			for( $i = 0; $i < count($data['item']); $i++ ){
				$query = "INSERT INTO menu_item (menu_id, item_id, people, quantity) VALUES ('{$menu_id}', '{$data['item'][$i]}', '{$data['people'][$i]}', {$data['quantity'][$i]})";
				$result = $this->db->query($query);
			}
		}
		
		public function update_menu($data){
			//update data
			$query = "UPDATE menu
				SET
				party_name = '{$data['party_name']}',
				event_date = '{$data['event_date']}',
				event_time = '{$data['event_time']}',
				num_person = '{$data['num_person']}',
				menu_price = '{$data['menu_price']}'
				WHERE menu_id = '{$data['menu_id']}' 
				";
			$result = $this->db->query($query);
			
			//empty item data
			$query = "DELETE FROM menu_item WHERE menu_id = '{$data['menu_id']}'";
			$result = $this->db->query($query);
			
			//update item data
			for( $i = 0; $i < count($data['item']); $i++ ){
				$query = "INSERT INTO menu_item (menu_id, item_id, people, quantity) VALUES ('{$data['menu_id']}', '{$data['item'][$i]}', '{$data['people'][$i]}', {$data['quantity'][$i]})";
				$result = $this->db->query($query);
			}
		}
		
		public function delete_menu($menu_id){
			//empty menu item data
			$query = "DELETE FROM menu_item WHERE menu_id = '{$menu_id}'";
			$result = $this->db->query($query);
			
			//delete menu data
			$query = "DELETE FROM menu WHERE menu_id = '{$menu_id}'";
			$result = $this->db->query($query);
		}
		
		public function get_all_menu($date){
			$query = "SELECT * FROM menu WHERE event_date = '{$date}'";
			$result = $this->db->query($query);
			return $result->result_array();
		}
		public function get_specific_menu($menu_id){
			$query = "SELECT * FROM menu WHERE menu_id = '{$menu_id}'";
			$result = $this->db->query($query);
			return $result->result_array()[0];
		}
		public function menu_estimation_done($menu_id){
			$query = "UPDATE menu SET estimated = TRUE WHERE menu_id = '{$menu_id}'";
			$result = $this->db->query($query);
		}
		public function menu_estimation_reset($menu_id){
			$query = "DELETE FROM menu_estimate WHERE menu_id = '{$menu_id}'";
			$result = $this->db->query($query);
			
			$query = "UPDATE menu SET estimated = FALSE WHERE menu_id = '{$menu_id}'";
			$result = $this->db->query($query);
		}
		public function is_menu_estimation_done($menu_id){
			$query = "SELECT * FROM menu WHERE menu_id = '{$menu_id}' AND estimated = '1'";
			$result = $this->db->query($query);
			return ($result->num_rows() > 0);
		}
		public function menu_approved($menu_id){
			$query = "UPDATE menu SET approved = TRUE WHERE menu_id = '{$menu_id}'";
			$result = $this->db->query($query);
		}
		public function get_menu_cost($menu_id){
			$query = "SELECT SUM(amount*probable_price) AS cost
				FROM menu_estimate, market
				WHERE menu_estimate.menu_id = '{$menu_id}'
				AND menu_estimate.event_date = market.date
				AND menu_estimate.ingredient_id = market.ingredient_id";
			$result = $this->db->query($query);
			return $result->result_array()[0]['cost'];
		}
		
		public function create_ingredient($data){
			$query = "INSERT INTO ingredient (ingredient_name, ingredient_unit, ingredient_price, ingredient_category)
			VALUES ( '{$data['ingredient_name']}', '{$data['ingredient_unit']}', '{$data['ingredient_price']}', '{$data['ingredient_category']}' )";
			$result = $this->db->query($query);
		}
		public function update_ingredient($data){
			$query = "UPDATE ingredient SET 
				ingredient_name = '{$data['ingredient_name']}',
				ingredient_price = '{$data['ingredient_price']}',
				ingredient_unit = '{$data['ingredient_unit']}',
				ingredient_category = '{$data['ingredient_category']}'
				WHERE ingredient_id = '{$data['ingredient_id']}'";
			$result = $this->db->query($query);
		}
		public function delete_ingredient($ingredient_id){
			$query = "DELETE FROM ingredient WHERE ingredient_id = '{$ingredient_id}'";
			$result = $this->db->query($query);
		}
		public function get_all_ingredient(){
			$query = "SELECT * FROM ingredient ORDER BY ingredient_name";
			$result = $this->db->query($query);
			return $result->result_array();
		}
		public function get_specific_ingredient($id){
			$query = "SELECT * FROM ingredient WHERE ingredient_id = '{$id}'";
			$result = $this->db->query($query);
			return $result->result_array()[0];
		}
		
		public function create_estimation($data){
			$query = "DELETE FROM menu_estimate WHERE menu_id = '{$data['menu_id']}'";
			$result = $this->db->query($query);
			for($i=0; $i<count($data['ingredient']); $i++){
				$query = "INSERT INTO menu_estimate (menu_id, ingredient_id, amount, event_date)
					VALUES ('{$data['menu_id']}', '{$data['ingredient'][$i]}',
					'{$data['amount'][$i]}', '{$data["menu_data"]['event_date']}')";
				$result = $this->db->query($query);
			}
		}
		public function get_estimation($menu_id){
			$query = "SELECT * FROM menu_estimate WHERE menu_id = '{$menu_id}'";
			$result = $this->db->query($query);
			return $result->result_array();
		}
		public function get_estimation_with_ingredients($menu_id){
			$query = "SELECT * FROM menu_estimate, ingredient
				WHERE menu_id = '{$menu_id}' AND menu_estimate.ingredient_id = ingredient.ingredient_id";
			$result = $this->db->query($query);
			return $result->result_array();
		}
		public function get_menu_item($menu_id){
			$query = "SELECT * FROM menu_item, item 
				WHERE menu_item.menu_id = '{$menu_id}' AND menu_item.item_id = item.item_id";
			$result = $this->db->query($query);
			return $result->result_array();
		}
		public function get_ingredients_for_menu($menu_id){
			$query = "SELECT * FROM ingredient
				WHERE ingredient_id IN
				(
				SELECT DISTINCT(ingredient_id)
				FROM menu_item, item_ingredient
				WHERE menu_item.menu_id = '{$menu_id}'
				AND menu_item.item_id = item_ingredient.item_id
				)
				";
			$result = $this->db->query($query);
			return $result->result_array();
		}
		
		public function get_ingredient_from_category($category){
			$query = "SELECT *
				FROM ingredient
				WHERE ingredient_category = '{$category}'
				";
			$result = $this->db->query($query);
			return $result->result_array();
		}
		
		public function get_ingredient_amount_for_menu_old($menu_id, $ingredient_id){
			$query = "SELECT *
				FROM menu
				WHERE menu_id = '{$menu_id}'
				";
			$result = $this->db->query($query);
			$result = $result->result_array();
			
			$people = $result[0]['num_person'];
			
			$query = "SELECT *
				FROM menu_item, item_ingredient
				WHERE menu_item.menu_id = '{$menu_id}'
				AND menu_item.item_id = item_ingredient.item_id
				AND item_ingredient.ingredient_id = '{$ingredient_id}'
				";
			$result = $this->db->query($query);
			$result = $result->result_array();
			$sum = 0;
			foreach($result as $r){
				if($r['people'] > 0) $sum += $people / $r['people'] * $r['quantity']; 
			}
			return $sum;
		}
		
		public function get_ingredient_amount_for_menu($menu_id, $ingredient_id){
			$query = "SELECT *
				FROM menu_item
				WHERE menu_id = '{$menu_id}'
				";
			$result = $this->db->query($query);
			$items = $result->result_array();
			
			$sum = 0;
			foreach($items as $item){
				$query = "SELECT *
					FROM item_ingredient
					WHERE item_id = '{$item['item_id']}'
					AND ingredient_id = '{$ingredient_id}'
				";
				$result = $this->db->query($query);
				$result = $result->result_array();
				foreach($result as $r){
					if($r['people'] > 0) $sum += $item['quantity'] * $item['people'] / $r['people'] * $r['quantity']; 
				}
			}
			return number_format($sum, 3);
		}
		
		public function get_ingredients_market($date){
			$query = "SELECT *
				FROM ingredient
				WHERE
				ingredient.ingredient_id IN
				(
				SELECT (ingredient_id) FROM menu_estimate
				WHERE
				event_date = '{$date}'
				)
				OR
				ingredient.ingredient_id IN
				(
				SELECT (ingredient_id) FROM extra
				WHERE
				date = '{$date}'
				)
				";

			$result = $this->db->query($query);
			return $result->result_array();
		}
		
		public function get_ingredients_for_item($item_id){
			$query = "SELECT *
				FROM ingredient, item_ingredient
				WHERE
				item_ingredient.item_id = {$item_id}
				AND item_ingredient.ingredient_id = ingredient.ingredient_id
				ORDER BY item_ingredient.ingredient_id";

			$result = $this->db->query($query);
			return $result->result_array();
		}
		
		public function update_market($data){
			$query = "DELETE FROM market
					WHERE date = '{$data['date']}'";
			$result = $this->db->query($query);
			for($i=0; $i<count($data['ingredient']); $i++){
				$query = "INSERT INTO market (date, ingredient_id, probable_price)
				VALUES ('{$data['date']}', '{$data['ingredient'][$i]}', '{$data['price'][$i]}')";
				$this->db->query($query);
			}
		}
		
		public function get_market($date){
			$query = "SELECT ingredient.ingredient_name, ingredient.ingredient_unit, 
				SUM(menu_estimate.amount) AS quantity, market.probable_price
				FROM ingredient, menu_estimate, market
				WHERE
				menu_estimate.event_date = '{$date}'
				AND menu_estimate.event_date = market.date
				AND ingredient.ingredient_id = menu_estimate.ingredient_id
				AND menu_estimate.ingredient_id = market.ingredient_id
				GROUP BY ingredient.ingredient_id";
			$result = $this->db->query($query);
			return $result->result_array();
		}
		
		public function get_extra($date){
			$query = "SELECT ingredient.ingredient_name, ingredient.ingredient_unit, 
				extra.amount AS quantity, market.probable_price
				FROM ingredient, extra, market
				WHERE
				extra.date = '{$date}'
				AND extra.date = market.date
				AND ingredient.ingredient_id = extra.ingredient_id
				AND extra.ingredient_id = market.ingredient_id
				";
			$result = $this->db->query($query);
			return $result->result_array();
		}
		
		public function is_price_set($date){
			$query = "SELECT * FROM market
						WHERE date = '{$date}'";
			$result = $this->db->query($query);
			return ( $result->num_rows() > 0 );
		}
		
		public function reset_price($date){
			$query = "DELETE FROM market
						WHERE date = '{$date}'";
			$result = $this->db->query($query);
		}
		
		public function is_extra_set($date){
			$query = "SELECT * FROM extra
						WHERE date = '{$date}'";
			$result = $this->db->query($query);
			return ( $result->num_rows() > 0 );
		}
		
		public function reset_extra($date){
			$query = "DELETE FROM extra
						WHERE date = '{$date}'";
			$result = $this->db->query($query);
		}
		
		public function update_extra($data){
			$query = "DELETE FROM extra
					WHERE date = '{$data['date']}'";
			$result = $this->db->query($query);
			for($i=0; $i<count($data['ingredient']); $i++){
				$query = "INSERT INTO extra (date, ingredient_id, amount)
				VALUES ('{$data['date']}', '{$data['ingredient'][$i]}', '{$data['amount'][$i]}')";
				$this->db->query($query);
			}
		}
		
		public function get_extra_cost($startDate, $endDate){
			$query="SELECT SUM(amount) * ingredient.ingredient_price AS x
				FROM extra, ingredient
				WHERE extra.date >= '{$startDate}'
				AND extra.date <= '{$endDate}'
				AND extra.ingredient_id = ingredient.ingredient_id
				GROUP BY extra.ingredient_id
				";
			$result = $this->db->query($query)->result_array();
			$sum = 0;
			foreach($result as $r) $sum += $r['x'];
			return $sum;
		}
		
		public function is_all_menu_estimated($date){
			$query = "SELECT * FROM menu WHERE event_date = '{$date}' AND estimated = '0'";
			$result = $this->db->query($query);
			return ( $result->num_rows() == 0 );
		}
		
		public function is_there_any_menu($date){
			$query = "SELECT * FROM menu WHERE event_date = '{$date}'";
			$result = $this->db->query($query);
			return ( $result->num_rows() > 0 );
		}
		public function is_there_error_in_range($dateStart, $dateEnd){
			$start = new DateTime($dateStart);
			$end = new DateTime($dateEnd);
			$today = new DateTime();
			
			if( $start > $end ) return "Invalid date range.";
			if( $start > $today ) return "Can't show the future.";
			
			$is_empty = TRUE;
			
			while($start <= $end) {
				if( $this->models->is_there_any_menu( $start->format('Y-m-d') ) == TRUE ){
					$is_empty = FALSE;
				}
				if( $this->models->is_there_any_menu( $start->format('Y-m-d') ) == TRUE AND $this->models->is_price_set( $start->format('Y-m-d') ) == FALSE ){
					return "Please set price first.";
				}
				$start->modify('+1 day');
			}
			
			if( $is_empty == TRUE ){
				return "No orders in date range.";
			}

			return NULL;
		}
		public function get_accounting($startDate, $endDate){
			$query = "SELECT * FROM menu 
			WHERE event_date >= '{$startDate}' AND event_date <= '{$endDate}'
			ORDER BY event_date DESC, party_name";
			$data["menus"] = $this->db->query($query)->result_array();
			$data["numberOfMenus"] = count($data["menus"]);
			$data["totalCost"] = 0;
			$data["totalIncome"] = 0;
			$data["misc"] = $this->models->get_extra_cost($startDate, $endDate);
			$data['admin_overhead'] = 0;
			$data['utility_overhead'] = 0;
			foreach($data["menus"] as $key => $value ){
				$data["menus"][$key]["cost"] = $this->models->get_menu_cost($data["menus"][$key]["menu_id"]);
				$data["menus"][$key]["income"] = $data["menus"][$key]["num_person"] * $data["menus"][$key]["menu_price"];
				
				$data["menus"][$key]["profit"] = $data["menus"][$key]["income"] - $data["menus"][$key]["cost"];
				
				$data["totalCost"] += $data["menus"][$key]["cost"];
				$data["totalIncome"] += $data["menus"][$key]["income"];
			}
			$data['admin_overhead'] = $data["totalIncome"] * .10;
			$data['utility_overhead'] = $data["totalIncome"] * .05;
			$data["profit"] = $data["totalIncome"] - $data["totalCost"] - $data['admin_overhead'] - $data['utility_overhead'];
			return $data;
		}
		
		public function logout(){
			$this->session->sess_destroy();
		}
		
		public function login($user_name, $password){
			$query = "SELECT * FROM user WHERE user_name = '{$user_name}' AND password = '{$password}'";
			$result = $this->db->query($query);
			if( $result->num_rows() == 0 ) return FALSE;
			$result = $result->result_array()[0];
			$newdata = array(
				'user_id' => $result["user_id"],
				'user_name'  => $user_name,
				'type'     => $result["type"],
				'logged_in' => TRUE
				);
			$this->session->set_userdata($newdata);
			return TRUE;
		}
		
		public function update_user($data){
			$query = "UPDATE user
				SET user_name = '{$data['user_name']}',
				password = '{$data['password']}',
				type = '{$data['type']}'
				WHERE user_id = '{$data['user_id']}'";
			$result = $this->db->query($query);
		}
		
		public function delete_user($user_id){
			$query = "DELETE FROM user WHERE user_id = '{$user_id}'";
			$result = $this->db->query($query);
		}
		
		public function create_user($user_name, $password, $type){
			$query = "INSERT INTO user (user_name, password, type) VALUES ('{$user_name}', '{$password}', '{$type}')";
			$result = $this->db->query($query);
		}
		
		public function get_all_user(){
			$query = "SELECT * FROM user";
			$result = $this->db->query($query);
			$result = $result->result_array();
			return $result;
		}
		
		public function get_specific_user($user_id){
			$query = "SELECT * FROM user WHERE user_id = '{$user_id}'";
			$result = $this->db->query($query);
			$result = $result->result_array();
			return $result[0];
		}
		
		public function is_logged_in(){
			return $this->session->userdata('logged_in');
		}
		
		public function is_admin(){
			return ( $this->session->userdata('type') == "admin" );
		}
		
		public function get_people($date){
			$query = "SELECT event_time, SUM(num_person) AS num_person FROM `menu` WHERE event_date = '{$date}' GROUP BY event_time";
			$result = $this->db->query($query);
			return $result->result_array();
		}
		
########################################################################
		
		public function create_store($data){
			
			for($i = 0; $i<count($data['ingredient']); $i++){
				$query = "INSERT INTO ingredient_transaction (ingredient_id, quantity, date, type, person_name) VALUES ('{$data['ingredient'][$i]}',  '{$data['quantity'][$i]}','{$data['event_date']}','{$data['type']}','{$data['person_name']}')";
				$result = $this->db->query($query);
			}
		}
		public function update_stock($change,$ingredient_id){
				$query = "UPDATE ingredient SET ingredient_stock = ingredient_stock + '{$change}' WHERE ingredient_id = '{$ingredient_id}'";
				$result = $this->db->query($query);
		}
		public function get_store_info($data){
			if($data['event_date'] == "0"){
				if($data['type'] == "0"){
					$query = "SELECT * FROM ingredient_transaction,ingredient WHERE   ingredient_transaction.ingredient_id = ingredient.ingredient_id" ;
					}
				else if($data['ingredient'] == "all"){
					$query = "SELECT * FROM ingredient_transaction,ingredient WHERE  ingredient_transaction.type = '{$data['type']}' AND ingredient_transaction.ingredient_id = ingredient.ingredient_id" ;
				}
				else{
				
					$query = "SELECT * FROM ingredient_transaction,ingredient WHERE  ingredient_transaction.ingredient_id = '{$data['ingredient']}' AND ingredient_transaction.type = '{$data['type']}' AND ingredient_transaction.ingredient_id = ingredient.ingredient_id" ;
				}
			}
			else{
				if($data['ingredient'] == "all"){
				 $query = "SELECT * FROM ingredient_transaction,ingredient WHERE ingredient_transaction.date = '{$data['event_date']}'  AND ingredient_transaction.type = '{$data['type']}' AND ingredient_transaction.ingredient_id = ingredient.ingredient_id" ;
				}
				else{
				
				 $query = "SELECT * FROM ingredient_transaction,ingredient WHERE ingredient_transaction.date = '{$data['event_date']}' AND ingredient_transaction.ingredient_id = '{$data['ingredient']}' AND ingredient_transaction.type = '{$data['type']}' AND ingredient_transaction.ingredient_id = ingredient.ingredient_id" ;
				}
			}
			
			$result = $this->db->query($query);
			return $result->result_array();
			
		}
		public function get_stock(){
			$query = "SELECT * FROM ingredient ORDER BY ingredient_name";
			$result = $this->db->query($query);
			return $result->result_array();
	    }
	}
?>
