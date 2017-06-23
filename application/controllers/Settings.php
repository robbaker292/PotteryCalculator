<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function index()
	{
		redirect("settings/listAll");
	}

	/**
	*	Handles the redirect after a save of an item. This is because settings do not have a "view" page
	*/
	public function view() {
		redirect("settings/listAll");
	}

	public function listAll() {
		$this->load->model('settings_model');
		$vat_list = $this->settings_model->getAllVAT();
		$pm_list = $this->settings_model->getAllPM();

		$data = array(
			'vat_list' => $vat_list,
			'pm_list' => $pm_list
		);
		$this->load->view('header', array(
			"title" => "Settings - Pottery by Andrew Macdermott"));
		$this->load->view('settings_list_view', $data);
		$this->load->view('footer');
	}

	/**
	*	Displays the edit page of the given vat rate
	*/
	public function editVat($id = null) {
		$this->load->model('settings_model');
		//is an war being created?
		if($id == "-1") {
			$data = array(
				'new' => true
			);
			$this->load->view('header', array("title" => "Creating: VAT rate - Pottery by Andrew Macdermott"));
			$this->load->view('settings_vat_edit_view', $data);
			$this->load->view('footer');
		//editing rather than creating
		} else {		
			$vat = $this->settings_model->getVat($id);
			
			if(count($vat) == 0) {
				redirect("settings/listAll");
			}
			$data = array(
				'vat' => $vat[0],
				'new' => false
			);
			$this->load->view('header', array("title" => "Editing: VAT rate - Pottery by Andrew Macdermott"));
			$this->load->view('settings_vat_edit_view', $data);
			$this->load->view('footer');
		}
	}

	/**
	* Handles the updating of a vat rate
	*/
	public function doUpdateVAT() {

		$basicForm = $this->input->post();
		//var_dump($basicForm);
		$this->load->model('settings_model');
		if($basicForm['end']=="0000-00-00" || $basicForm['end']=="") {
			$basicForm['end'] = null;
		}
		if($basicForm['id']=="") {
			//add new update
			$result = $this->settings_model->addVAT($basicForm);
		} else {
			//edit update
			$result = $this->settings_model->editVAT($basicForm);
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
	*	Displays the edit page of the given payment method
	*/
	public function editPM($id = null) {
		$this->load->model('settings_model');
		//is an war being created?
		if($id == "-1") {
			$data = array(
				'new' => true
			);
			$this->load->view('header', array("title" => "Creating: Payment Method - Pottery by Andrew Macdermott"));
			$this->load->view('settings_pm_edit_view', $data);
			$this->load->view('footer');
		//editing rather than creating
		} else {	
			$id = urldecode($id);

			$pm = $this->settings_model->getPM($id);
			
			if(count($pm) == 0) {
				redirect("settings/listAll");
			}
			$data = array(
				'pm' => $pm[0],
				'new' => false
			);
			$this->load->view('header', array("title" => "Editing: Payment Method - Pottery by Andrew Macdermott"));
			$this->load->view('settings_pm_edit_view', $data);
			$this->load->view('footer');
		}
	}

	/**
	* Handles the updating of a payment method
	*/
	public function doUpdatePM() {

		$basicForm = $this->input->post();
		//var_dump($basicForm);
		$this->load->model('settings_model');
		if($basicForm['id']=="") {
			//add new update
			$result = $this->settings_model->addPM($basicForm);
		} else {
			//edit update
			$result = $this->settings_model->editPM($basicForm);
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