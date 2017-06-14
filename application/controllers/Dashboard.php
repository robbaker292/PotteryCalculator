<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	*	Displays the details of the given event
	*/
	public function index() {

		$this->load->model('dashboard_model');
		$sales_data = $this->dashboard_model->getSales();

		$data = array(
			'sales_data' => $sales_data
		);
		$this->load->view('header', array(
			"title" => "Dashboard - Pottery by Andrew Macdermott"));
		$this->load->view('dashboard_view', $data);
		$this->load->view('footer');
	}

	/**
	*	Loads the AJAX data
	*/
	public function getData() {
		$this->load->model('dashboard_model');
		$sales_data = $this->dashboard_model->getSales();

		$product_data = new stdClass();
		$product_data->profit = 0;
		$product_data->selling_price = 0;
		$product_data->profits = array();
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
			if(isset($product_data->profits[$sale->date])) {
				$product_data->profits[$sale->date] += $sale->profit;
			} else {
				$product_data->profits[$sale->date] = $sale->profit;
			}
		}

		//add in missing days
		$keys = array_keys($product_data->profits);
		$begin = date_create($keys[0]);
		$end = date_create($keys[count($keys)-1]);
		$i = new DateInterval('P1D');
		$period=new DatePeriod($begin,$i,$end);
		foreach ($period as $d){
			$day=$d->format('Y-m-d');
			if(!isset($product_data->profits[$day])){
				$product_data->profits[$day] = 0;
			};
		}
		ksort($product_data->profits);

		$output = array();
		foreach($product_data->profits as $key => $value) {
			$output[] = array(
				"date" => $key,
				"profit" => $value
			);
		}

		echo json_encode($output);
		//var_dump($product_data);
	}

}
