<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {

	public function index()
	{
		echo "hello";
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

		$data = array(
			'event_data' => $event_data,
			'sales_data' => $sales_data
		);
		$this->load->view('header', array(
			"title" => $event_data->name." - Pottery by Andrew Macdermott"));
		$this->load->view('event_view', $data);
		$this->load->view('footer');
	}

}
