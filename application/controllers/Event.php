<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {

	public function index()
	{
		redirect("event/listAll");
	}

	/**
	*	Displays the details of the given event
	*/
	public function view($id, $name = null) {

		$this->load->model('event_model');
		$event_data = $this->event_model->getEvent($id)[0];
		$sales_data = $this->event_model->getSales($id);
		//$resources_data = $this->event_model->getResources($id);
		//redirect if invalid url
		if(count($event_data) == 0) {
			redirect(site_url());
		}
		//rewrite url to be nicer
		if($name == null) {
			$name = urlencode($event_data->name);
			redirect(site_url(uri_string()."/".$name));
		}
	
		$event_data->profit = 0;
		$event_data->selling_price = 0;
		$event_data->profits = array();
		$products = array();
		$products_name = array();
		$total_revenue = 0;
		$total_time = 0;
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
			$event_data->profit += $sale->profit;
			$event_data->selling_price += $sale->sale_price;
			if(isset($event_data->profits["p".$sale->product_id])) {
				$event_data->profits["p".$sale->product_id] += $sale->profit;
			} else {
				$event_data->profits["p".$sale->product_id] = $sale->profit;
			}
			$total_time += floatval($sale->time);
			$products["p".$sale->product_id] = $sale->product_id;
			$products_name["p".$sale->product_id] = $sale->product_name;
		}

		if(count($sales_data) != 0) {

			$total_time = $total_time / count($sales_data);

			//calculate other product details
			$event_data->avg_profit = $event_data->profit / count($sales_data);

			if($total_revenue != 0){
				$event_data->margin = ($event_data->profit / $total_revenue)*100;
			} else {
				$event_data->margin = "N/A";
			}

			$event_data->avg_rate = $event_data->profit / ($total_time * count($sales_data));
			$event_data->avg_selling_price = $event_data->selling_price / count($sales_data);

			$event_data->max_event_profit = max($event_data->profits);
			$event_data->max_event = array_keys($event_data->profits, max($event_data->profits))[0];
			$event_data->max_event_id = $products[$event_data->max_event];
			$event_data->max_event_name = $products_name[$event_data->max_event];

			$event_data->min_event_profit = min($event_data->profits);
			$event_data->min_event = array_keys($event_data->profits, min($event_data->profits))[0];
			$event_data->min_event_id = $products[$event_data->min_event];
			$event_data->min_event_name = $products_name[$event_data->min_event];
		}

		$data = array(
			'event_data' => $event_data,
			'sales_data' => $sales_data
		);
		$this->load->view('header', array(
			"title" => $event_data->name." - Pottery by Andrew Macdermott"));
		$this->load->view('event_view', $data);
		$this->load->view('footer');
	}

	public function listAll() {
		$this->load->model('event_model');
		$event_total_data = $this->event_model->getAllEvents();

		foreach($event_total_data as $event_data) {
			$id = $event_data->id;
			$sales_data = $this->event_model->getSales($id);
		
			$event_data->sales_count = count($sales_data);
			$event_data->profit = 0;
			$event_data->selling_price = 0;
			$event_data->profits = array();
			$products = array();
			$products_name = array();
			$total_revenue = 0;
			$total_time = 0;
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
				$event_data->profit += $sale->profit;
				$event_data->selling_price += $sale->sale_price;
				if(isset($event_data->profits["p".$sale->product_id])) {
					$event_data->profits["p".$sale->product_id] += $sale->profit;
				} else {
					$event_data->profits["p".$sale->product_id] = $sale->profit;
				}
				$total_time += floatval($sale->time);
				$products["p".$sale->product_id] = $sale->product_id;
				$products_name["p".$sale->product_id] = $sale->product_name;
			}

			if(count($sales_data) != 0) {
				$total_time = $total_time / count($sales_data);

				//calculate other product details
				$event_data->avg_profit = $event_data->profit / count($sales_data);

				if($total_revenue != 0){
					$event_data->margin = ($event_data->profit / $total_revenue)*100;
				} else {
					$event_data->margin = "N/A";
				}

				$event_data->avg_rate = $event_data->profit / ($total_time * count($sales_data));
				$event_data->avg_selling_price = $event_data->selling_price / count($sales_data);
			}
			
		}

		$data = array(
			'event_total_data' => $event_total_data
		);
		$this->load->view('header', array(
			"title" => "List All Events - Pottery by Andrew Macdermott"));
		$this->load->view('event_list_view', $data);
		$this->load->view('footer');
	}


	/**
	*	Displays the edit page of the given event
	*/
	public function edit($id = null) {
		$this->load->model('event_model');
		//is an war being created?
		if($id == "-1") {
			$data = array(
				'new' => true
			);
			$this->load->view('header', array("title" => "Creating: Event - Pottery by Andrew Macdermott"));
			$this->load->view('event_edit_view', $data);
			$this->load->view('footer');
		//editing rather than creating
		} else {		
			$event = $this->event_model->getEvent($id);
			
			if(count($event) == 0) {
				redirect("event/listAll");
			}
			$data = array(
				'event' => $event[0],
				'new' => false
			);
			$this->load->view('header', array("title" => "Editing: ".$event[0]->name." - Pottery by Andrew Macdermott"));
			$this->load->view('event_edit_view', $data);
			$this->load->view('footer');
		}
	}

	/**
	* Handles the updating of an event
	*/
	public function doUpdate() {

		$basicForm = $this->input->post();
		//var_dump($basicForm);
		$this->load->model('event_model');
		if($basicForm['id']=="") {
			//add new update
			$result = $this->event_model->addEvent($basicForm);
		} else {
			//edit update
			$result = $this->event_model->editEvent($basicForm);
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
	*	Deletes an event
	*/
	public function delete($id) {
		$this->load->model('event_model');
		$result = $this->event_model->deleteEvent($id);
		//if the update worked
		if($result["type"] == "success") {
			//var_dump($result);
			redirect("event/listAll");
		} else {
			//output the error message :(
			header('HTTP/1.1 500 Internal Server Error');
   			header('Content-Type: application/json; charset=UTF-8');
    		die(json_encode($result));
		}

	}

}
