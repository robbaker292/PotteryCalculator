<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	*	Displays the details of the given event
	*/
	public function index() {

		$this->load->model('dashboard_model');

		$this->load->view('header', array(
			"title" => "Dashboard - Pottery by Andrew Macdermott"));
		$this->load->view('dashboard_view');
		$this->load->view('footer');
	}

	/**
	*	Loads the AJAX data
	*/
	public function getData($start_date = null, $end_date = null) {

		if($start_date == null) {
            $start_date = new DateTime(date('Y-m-d', strtotime('-30 days')));
        } else {
        	$start_date = new DateTime($start_date);
        }
        if($end_date == null) {
            $end_date = new DateTime('now');
        } else {
        	$end_date = new DateTime($end_date);
        }
       // var_dump($start_date);

		$this->load->model('dashboard_model');
		$sales_data = $this->dashboard_model->getSales($start_date, $end_date);
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
		/*if($start_date == null) {
			$start_date = date_create($keys[0]);
		}
		if($end_date == null) {
			$end_date = date_create($keys[count($keys)-1]);
		}*/
		$i = new DateInterval('P1D');
		$period=new DatePeriod($start_date,$i,$end_date);
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

		/**
	*	Loads the AJAX data
	*/
	public function getFromDate($date) {
		$date = new DateTime($date);
       // var_dump($start_date);

		$this->load->model('dashboard_model');
		$sales_data = $this->dashboard_model->getSales($date, $date);
		$product_data = new stdClass();
		$product_data->profit = 0;
		$product_data->selling_price = 0;
		$product_data->profits = array();
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
			$total_time += floatval($sale->time);
			$product_data->profit += $sale->profit; //store total profits
			$product_data->selling_price += $sale->sale_price; //store total selling prices
		}
		$product_data->sales_count = count($sales_data);
		$product_data->sales = $sales_data;

		$total_time = $total_time / count($sales_data);

		//calculate other product details
		$product_data->avg_profit = $product_data->profit / count($sales_data);

		if($total_revenue != 0){
			$product_data->margin = ($product_data->profit / $total_revenue)*100;
		} else {
			$product_data->margin = "N/A";
		}

		$product_data->avg_rate = $product_data->profit / ($total_time * count($sales_data));
		$product_data->avg_selling_price = $product_data->selling_price / count($sales_data);

		$data = array(
			'product_data' => $product_data
		);
		$this->load->view('dashboard_summary_view', $data);
		$this->load->view('dashboard_sales_view', array('sales_data' => $product_data->sales));

		//var_dump($product_data);
	}

}
