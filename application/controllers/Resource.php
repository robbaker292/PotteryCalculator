<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resource extends CI_Controller {

	public function index()
	{
		echo "hello";
	}

	/**
	*	Displays the details of the given resource
	*/
	public function view($id, $name = null) {
		$this->load->model('resource_model');
		$resource_data = $this->resource_model->getResource($id)[0];
		$product_data = $this->resource_model->getProductsWithResource($id);

		//redirect if invalid url
		if(count($resource_data) == 0) {
			redirect(site_url());
		}
		//rewrite url to be nicer
		if($name == null) {
			$name = urlencode($resource_data->name);
			redirect(site_url(uri_string()."/".$name));
		}

		$data = array(
			'resource_data' => $resource_data,
			'product_data' => $product_data
		);
		$this->load->view('header', array(
			"title" => $resource_data->name." - Pottery by Andrew Macdermott"));
		$this->load->view('resource_view', $data);
		$this->load->view('footer');
	}

	/**
	*	Displays the details of the all resources
	*/
	public function listAll() {
		$this->load->model('resource_model');
		$resource_total_data = $this->resource_model->getAllResources();

		foreach($resource_total_data as $resource_data) {
			$id = $resource_data->id;
			$product_data = $this->resource_model->getProductsWithResource($id);
			$resource_data->product_count = count($product_data);
		}

		$data = array(
			'resource_total_data' => $resource_total_data
		);
		$this->load->view('header', array(
			"title" => "List all Resources - Pottery by Andrew Macdermott"));
		$this->load->view('resource_list_view', $data);
		$this->load->view('footer');
	}

}