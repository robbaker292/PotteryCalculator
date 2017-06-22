<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	private $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');

	/**
	*	Displays the details of the given event
	*/
	public function index() {

		$this->load->model('dashboard_model');

		$this->load->view('header', array(
			"title" => "Dashboard - Pottery by Andrew Macdermott"));
		$this->load->view('dashboard_view', array(
			"start_date" => (new DateTime(date('Y-m-d', strtotime('-30 days'))))->format('Y-m-d'),
			"end_date" => (new DateTime('now'))->format('Y-m-d')
			));
		$this->load->view('footer');
	}

	/**
	*	Loads the AJAX data for drawing the graph
	*/
	public function getData($start_date = null, $end_date = null, $group = null) {

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

        if ($group == null) {
        	$group = "day";
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

		//convert to output array
		$output_profits = array();
		$keys = array_keys($product_data->profits);
		foreach($product_data->profits as $key => $value) {
			if($group == "week") { //if weeks
				$weekNum = (new DateTime($key))->format('o-W');
				//var_dump($weekNum);
				if(!isset($output_profits[$weekNum])) { //might not be set, so initialise to 0
					$output_profits[$weekNum] = 0;
				}
				$output_profits[$weekNum] += $value;

			} elseif($group == "month") { //if month
				$month = (new DateTime($key))->format('Y-m');
				if(!isset($output_profits[$month])) { //might not be set, so initialise to 0
					$output_profits[$month] = 0;
				}
				$output_profits[$month] += $value;
			} else { //if days
				$output_profits[$key] = $value;
			}
		}

		//var_dump($output_profits);

		//fill in missing gaps
		if($group == "month") {
			$i = new DateInterval('P1M');
		} elseif($group == "week") {
			$i = new DateInterval('P1W');
		} else {
			$i = new DateInterval('P1D');
		}		
		$period=new DatePeriod($start_date,$i,$end_date);
		foreach ($period as $d){
			$day = $d->format('Y-m-d');
			$week = $d->format('o-W');
			$month = $d->format('Y-m');
			//if weeks
			if($group == "week") {
				if(!isset($output_profits[$week])){ //if it is not set, then there are no results for this time period
					$output_profits[$week] = 0;
				}
			} elseif($group == "month") { //if month
				if(!isset($output_profits[$month])){ //if it is not set, then there are no results for this time period
					$output_profits[$month] = 0;
				}
			} else {
				//if days
				if(!isset($output_profits[$day])){ //if it is not set, then there are no results for this time period
					$output_profits[$day] = 0;
				}
			}

			
		}
		ksort($output_profits);

		$output = array();
		foreach($output_profits as $key => $value) {
			$output[] = array(
				"date" => $key,
				"profit" => $value
			);
		}


		echo json_encode($output);
		//var_dump($output);
	}

	/**
	*	Loads the AJAX data to display the drilldowns later in the page
	*/
	public function getFromDate($date, $group) {
		if($group == "day") {
			$date = new DateTime($date);
			$end_date = $date;
		} else {
			$end_date = substr($date,0,4);
			$date = substr($date,5);
		}

        var_dump($end_date);

		$this->load->model('dashboard_model');
		$sales_data = $this->dashboard_model->getSales($date, $end_date, $group);
		$product_data = new stdClass();
		$product_data->profit = 0;
		$product_data->selling_price = 0;
		$product_data->profits = array();
		$total_revenue = 0;
		$total_time = 0;
		//calculate profit
		//var_dump($sales_data);
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
