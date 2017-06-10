<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index()
	{
		echo "hello";
	}

	/**
	*	Displays the details of the given casualty
	*/
	public function view($id, $name = null) {

		$this->load->model('product_model');
		$product_data = $this->product_model->getProduct($id);
		//redirect if invalid url
		if(count($product_data) == 0) {
			redirect(site_url());
		}
		//rewrite url to be nicer
		if($name == null) {
			$name = urlencode($product_data[0]->name);
			redirect(site_url(uri_string()."/".$name));
		}
	
		$data = array(
			'product_data' => $product_data[0],
		);
		$this->load->view('header', array(
			"title" => $product_data[0]->name." - Pottery by Andrew Macdermott"));
		$this->load->view('product_view', $data);
		$this->load->view('footer');
		//redirect("Casualty/view/{$id}/{$str_slug}");
	}

}
