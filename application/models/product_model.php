<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /*
    * Returns all the data about the given casualty
    */
    public function getProduct($id) {
        $sql = "SELECT * FROM product";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

}