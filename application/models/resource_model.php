<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Resource_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /*
    * Returns all the data about the given Resource
    */
    public function getResource($id) {
        $sql = "SELECT * FROM resource WHERE id=?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    /*
    * Returns all the data about all Resource
    */
    public function getAllResources() {
        $sql = "SELECT * FROM resource";
        $query = $this->db->query($sql);
        return $query->result();
    }

    /*
    * Returns all the data about the given Resource
    */
    public function getProductsWithResource($id) {
        $sql = "SELECT p.id, p.name, pr.amount, (pr.amount / r.size) * r.price_paid AS cost FROM resource r
            JOIN product_resource pr ON pr.rid = r.id 
            JOIN product p ON pr.pid = p.id
            WHERE r.id=?
        ";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }
}