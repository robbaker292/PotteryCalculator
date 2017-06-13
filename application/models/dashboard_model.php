<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /*
    * Returns all the data about sales
    */
    public function getSales() {
        $sql = "SELECT * FROM sale";
        $query = $this->db->query($sql);
        return $query->result();
    }

}