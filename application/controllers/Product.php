<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index()
	{
		redirect("product/listAll");
	}

	/**
	*	Displays the details of the given product
	*/
	public function view($id, $name = null) {

		$this->load->model('product_model');
		$product_data = $this->product_model->getProduct($id)[0];
		$sales_data = $this->product_model->getSales($id);
		$resources_data = $this->product_model->getResources($id);
		//redirect if invalid url
		if(count($product_data) == 0) {
			redirect(site_url());
		}
		//rewrite url to be nicer
		if($name == null) {
			$name = urlencode($product_data->name);
			redirect(site_url(uri_string()."/".$name));
		}

		$product_data->sales_count = count($sales_data);
		$product_data->profit = 0;
		$product_data->selling_price = 0;
		$product_data->profits = array();
		$events = array();
		$events_location = array();
		$total_revenue = 0;
		//calculate profit
		foreach($sales_data as $sale) {
			$sale->revenue = (floatval($sale->sale_price) * (1-floatval($sale->cut))) / (1+floatval($sale->vat));
			$total_revenue += $sale->revenue;
			$event_cost = (floatval($sale->sale_price) * floatval($sale->cost_sales)) + floatval($sale->calculated_cost_upfront);
			$sale->profit = $sale->revenue - ($event_cost + floatval($sale->parts_cost));
			$sale->hourly_rate = $sale->profit / floatval($sale->time);
			if($sale->revenue != 0){
				$sale->margin = ($sale->profit / $sale->revenue)*100;
			} else {
				$sale->margin = "N/A";
			}
			$product_data->profit += $sale->profit;
			$product_data->selling_price += $sale->sale_price;
			if(isset($product_data->profits[$sale->event_id])) {
				$product_data->profits[$sale->event_id] += $sale->profit;
			} else {
				$product_data->profits[$sale->event_id] = $sale->profit;
			}
			$events[$sale->event_id] = $sale->event_name;
			$events_location[$sale->event_id] = $sale->event_location;
		}

		//calculate resource cost
		foreach($resources_data as $resource) {
			$resource->cost = (floatval($resource->amount) / floatval($resource->size)) * floatval($resource->price_paid);
		}

		//calculate other product details
		if(count($sales_data) > 0) {
			$product_data->avg_profit = $product_data->profit / count($sales_data);
		}

		if($total_revenue != 0){
			$product_data->margin = ($product_data->profit / $total_revenue)*100;
		} else {
			$product_data->margin = "N/A";
		}

		if(count($sales_data) > 0) {
			$product_data->avg_rate = $product_data->profit / (floatval($product_data->time) * count($sales_data));
			$product_data->avg_selling_price = $product_data->selling_price / count($sales_data);
			unset($product_data->profits[""]); //remove the "no event";

			if(count($product_data->profits) > 0) { //in case there are no events for this item
				$product_data->max_event_profit = max($product_data->profits);
				$product_data->max_event = array_keys($product_data->profits, max($product_data->profits))[0];
				$product_data->max_event_name = $events[$product_data->max_event];
				$product_data->max_event_location = $events_location[$product_data->max_event];

				$product_data->min_event_profit = min($product_data->profits);
				$product_data->min_event = array_keys($product_data->profits, min($product_data->profits))[0];
				$product_data->min_event_name = $events[$product_data->min_event];
				$product_data->min_event_location = $events_location[$product_data->min_event];
			}
		}
	
		$data = array(
			'product_data' => $product_data,
			'sales_data' => $sales_data,
			'resources_data' => $resources_data
		);
		$this->load->view('header', array(
			"title" => $product_data->name." - Pottery by Andrew Macdermott"));
		$this->load->view('product_view', $data);
		$this->load->view('footer');
		//redirect("Casualty/view/{$id}/{$str_slug}");
	}

	public function listAll() {

		$this->load->model('product_model');
		$product_total_data = $this->product_model->getAllProducts();

		foreach($product_total_data as $product_data) {

			$id = $product_data->id;
			$sales_data = $this->product_model->getSales($id);
			$resources_data = $this->product_model->getResources($id);

			$product_data->profit = 0;
			$product_data->selling_price = 0;
			$product_data->sales_count = count($sales_data);
			$total_revenue = 0;
			//calculate profit
			foreach($sales_data as $sale) {
				$sale->revenue = (floatval($sale->sale_price) * (1-floatval($sale->cut))) / (1+floatval($sale->vat));
				$total_revenue += $sale->revenue;
				$event_cost = (floatval($sale->sale_price) * floatval($sale->cost_sales)) + floatval($sale->calculated_cost_upfront);
				$sale->profit = $sale->revenue - ($event_cost + floatval($sale->parts_cost));
				$sale->hourly_rate = $sale->profit / floatval($sale->time);
				if($sale->revenue != 0){
					$sale->margin = ($sale->profit / $sale->revenue)*100;
				} else {
					$sale->margin = "N/A";
				}
				$product_data->profit += $sale->profit;
				$product_data->selling_price += $sale->sale_price;
			}

			//calculate resource cost
			foreach($resources_data as $resource) {
				$resource->cost = (floatval($resource->amount) / floatval($resource->size)) * floatval($resource->price_paid);
			}

			//calculate other product details
			if(count($sales_data) != 0) {
				$product_data->avg_profit = $product_data->profit / count($sales_data);
			}			

			if($total_revenue != 0){
				$product_data->margin = ($product_data->profit / $total_revenue)*100;
			} else {
				$product_data->margin = "N/A";
			}

			if(count($sales_data) != 0) {
				$product_data->avg_rate = $product_data->profit / (floatval($product_data->time) * count($sales_data));
				$product_data->avg_selling_price = $product_data->selling_price / count($sales_data);
			}
		}

		$data = array(
			'product_total_data' => $product_total_data
		);
		$this->load->view('header', array(
			"title" => "Product List - Pottery by Andrew Macdermott"));
		$this->load->view('product_list_view', $data);
		$this->load->view('footer');
	}

	/**
	*	Displays the edit page of the given product
	*/
	public function edit($id = null) {
		$this->load->model('product_model');
		$all_resources = $this->product_model->getAllResources();
		//is an product being created?
		if($id == "-1") {
			$data = array(
				'resources' => array(),
				'all_resources' => $all_resources,
				'new' => true
			);
			$this->load->view('header', array("title" => "Creating: Product - Pottery by Andrew Macdermott"));
			$this->load->view('product_edit_view', $data);
			$this->load->view('footer');
		//editing rather than creating
		} else {		
			$product = $this->product_model->getProduct($id);
			$resources_data = $this->product_model->getResources($id);
			
			if(count($product) == 0) {
				redirect("product/listAll");
			}
			$data = array(
				'product' => $product[0],
				'resources' => $resources_data,
				'all_resources' => $all_resources,
				'new' => false
			);
			$this->load->view('header', array("title" => "Editing: ".$product[0]->name." - Pottery by Andrew Macdermott"));
			$this->load->view('product_edit_view', $data);
			$this->load->view('footer');
		}
	}

	/**
	* Handles the updating of an product
	*/
	public function doUpdate() {

		$basicForm = $this->input->post();
		$this->load->model('product_model');
		if($basicForm['id']=="") {
			//add new update
			$result = $this->product_model->addProduct($basicForm);
		} else {
			//edit update
			$result = $this->product_model->editProduct($basicForm);
		}
		//if the update worked
		if($result["type"] == "success") {
			//store the result data
			$this->session->set_flashdata($result);
			echo json_encode($result);
		} else {
			//output the error message :(
			header('HTTP/1.1 500 Internal Server Error');
   			header('Content-Type: application/json; charset=UTF-8');
    		die(json_encode($result));
		}
		
	}

	/**
	*	Returns the AJAX code to create the extra resource dropdowns
	*/
	public function createResourceDropdowns() {
		$this->load->model('product_model');
		$all_resources = $this->product_model->getAllResources();
echo"			<div class=\"resourceOptions\">
					<div class=\"form-group\">
						<label class=\"control-label col-sm-3\" for=\"resources\">Current Resources:</label>
						<div class=\"col-sm-4\">
							<select class=\"form-control selectpicker\" name=\"resources[]\" data-live-search=\"true\" multiple data-max-options=\"1\">";
								
								foreach($all_resources as $rL) {
									echo "<option value=\"".$rL->id."\" data-subtext=\"Bought ".$rL->date_bought."\"";
									echo ">(".$rL->id.") ".$rL->name." (".$rL->unit_type.")</option>";
								}
	echo							"
							</select>
						</div>
						<div class=\"col-sm-5\">
							<input type=\"text\" class=\"form-control\" id=\"name\" placeholder=\"Enter Amount\" name=\"amount\">
						</div>
					</div>
				</div>
			";
	}

	/**
	* Handles the updating of resources
	*/
	public function doUpdateResources($id) {
		
		$basicForm = $this->input->post();
		if(count($basicForm) > 0) {
			$this->load->model('product_model');
			//update casualty
			$result = $this->product_model->updateResources($id, $basicForm);
			//if the update worked
			if($result["type"] == "success") {
				//store the result data
				$this->session->set_flashdata($result);
				echo json_encode($result);
			} else {
				//output the error message :(
				header('HTTP/1.1 500 Internal Server Error');
       			header('Content-Type: application/json; charset=UTF-8');
        		die(json_encode($result));
			}
		}			

	}

	/**
	*	Deletes a product
	*/
	public function delete($id) {
		$this->load->model('product_model');
		$result = $this->product_model->deleteProduct($id);
		//if the update worked
		if($result["type"] == "success") {
			//var_dump($result);
			redirect("product/listAll");
		} else {
			//output the error message :(
			header('HTTP/1.1 500 Internal Server Error');
   			header('Content-Type: application/json; charset=UTF-8');
    		die(json_encode($result));
		}

	}

}
