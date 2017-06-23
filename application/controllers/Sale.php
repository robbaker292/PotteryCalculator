<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends CI_Controller {

	public function index()
	{
		redirect("dashboard");
	}

	/**
	*	Displays the edit page of the given sale
	*/
	public function edit($id = null) {
		$this->load->model('sale_model');
		$payment_methods = $this->sale_model->getPaymentMethods();
		$products = $this->sale_model->getProducts();
		$events = $this->sale_model->getEvents();

		//is an sale being created?
		if($id == "-1") {
			$data = array(
				'payment_methods' => $payment_methods,
				'products' => $products,
				'events' => $events,
				'new' => true
			);
			$this->load->view('header', array("title" => "Creating: Sale - Pottery by Andrew Macdermott"));
			$this->load->view('sale_edit_view', $data);
			$this->load->view('footer');
		//editing rather than creating
		} else {		
			$sale = $this->sale_model->getSale($id);
			if(count($sale) == 0) {
				redirect("dashboard");
			}
			$data = array(
				'sale' => $sale[0],
				'payment_methods' => $payment_methods,
				'products' => $products,
				'events' => $events,
				'new' => false
			);
			$this->load->view('header', array("title" => "Editing: Sale - Pottery by Andrew Macdermott"));
			$this->load->view('sale_edit_view', $data);
			$this->load->view('footer');
		}
	}

	/**
	* Handles the updating of a sale
	*/
	public function doUpdate() {

		$basicForm = $this->input->post();
		$this->load->model('sale_model');
		if($basicForm['event'] == "null") {
			$basicForm['event'] = null;
		}

		if($basicForm['id']=="") {
			//add new update
			$result = $this->sale_model->addSale($basicForm);
		} else {
			//edit update
			$result = $this->sale_model->editSale($basicForm);
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
	*	Handles the AJAX for a potential sale
	*/
	public function getPotentialSale($product, $event, $pm, $date, $type) {
		$this->load->model('sale_model');
		$sale = $this->sale_model->getPotentialSale($product, $event, $pm, $date)[0];

		$output = array();
		for($i = 5; $i <= 100; $i +=5) {
			$revenue = ($i * (1-floatval($sale->cut))) / (1+floatval($sale->vat));
			$event_cost = ($i * floatval($sale->cost_sales)) + floatval($sale->calculated_cost_upfront);
			$profit = $revenue - ($event_cost + floatval($sale->parts_cost));
			$hourly_rate = $profit / floatval($sale->time);
			$margin = ($profit / $revenue)*100;
			$sale_price = $i;
			$output[] = array(
				"sale_price" => $sale_price,
				"revenue" => $revenue,
				"event_cost" => $event_cost,
				"profit" => $profit,
				"hourly_rate" => $hourly_rate,
				"margin" => $margin,
				"parts_cost" => $sale->parts_cost
				);
		}

		if($type == "0") {
			$data = array(
				'sales_data' => $output
			);
			$this->load->view('sale_potential_view', $data);
		} else {
			echo json_encode($output);
		}
		

	}

}