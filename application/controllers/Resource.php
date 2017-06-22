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

	/**
	*	Displays the edit page of the given resource
	*/
	public function edit($id = null) {
		$this->load->model('resource_model');
		//is an resource being created?
		if($id == "-1") {
			$data = array(
				'new' => true
			);
			$this->load->view('header', array("title" => "Creating: Resource - Pottery by Andrew Macdermott"));
			$this->load->view('resource_edit_view', $data);
			$this->load->view('footer');
		//editing rather than creating
		} else {		
			$event = $this->resource_model->getResource($id);
			
			if(count($event) == 0) {
				redirect("resource/listAll");
			}
			$data = array(
				'resource' => $event[0],
				'new' => false
			);
			$this->load->view('header', array("title" => "Editing: ".$event[0]->name." - Pottery by Andrew Macdermott"));
			$this->load->view('resource_edit_view', $data);
			$this->load->view('footer');
		}
	}

	/**
	* Handles the updating of an resource
	*/
	public function doUpdate() {

		$basicForm = $this->input->post();
		//var_dump($basicForm);
		$this->load->model('resource_model');
		if($basicForm['id']=="") {
			//add new update
			$result = $this->resource_model->addResource($basicForm);
		} else {
			//edit update
			$result = $this->resource_model->editResource($basicForm);
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

}