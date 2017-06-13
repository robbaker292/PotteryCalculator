<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index()
	{
		echo "hello";
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

		$product_data->profit = 0;
		$product_data->selling_price = 0;
		$product_data->profits = array();
		$events = array();
		$events_location = array();
		$total_revenue = 0;
		//calculate profit
		foreach($sales_data as $sale) {
			$sale->revenue = floatval($sale->sale_price) * (1-floatval($sale->vat)) * (1-floatval($sale->cut));
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
		$product_data->avg_profit = $product_data->profit / count($sales_data);

		if($total_revenue != 0){
			$product_data->margin = ($product_data->profit / $total_revenue)*100;
		} else {
			$product_data->margin = "N/A";
		}

		$product_data->avg_rate = $product_data->profit / (floatval($product_data->time) * count($sales_data));
		$product_data->avg_selling_price = $product_data->selling_price / count($sales_data);
		unset($product_data->profits[""]); //remove the "no event";

		$product_data->max_event_profit = max($product_data->profits);
		$product_data->max_event = array_keys($product_data->profits, max($product_data->profits))[0];
		$product_data->max_event_name = $events[$product_data->max_event];
		$product_data->max_event_location = $events_location[$product_data->max_event];

		$product_data->min_event_profit = min($product_data->profits);
		$product_data->min_event = array_keys($product_data->profits, min($product_data->profits))[0];
		$product_data->min_event_name = $events[$product_data->min_event];
		$product_data->min_event_location = $events_location[$product_data->min_event];
	
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

}
