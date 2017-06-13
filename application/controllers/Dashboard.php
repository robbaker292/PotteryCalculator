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

}
