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

    /**
    *  Updates an Resource
    */
    public function editResource($basicForm) {
        $sql = "UPDATE resource SET name=?, description=?, date_bought=?, size=?, unit_type=?, price_paid=? WHERE id=?";
        $result = $this->db->query($sql, array($basicForm['name'], $basicForm['description'], $basicForm['date_bought'], $basicForm['size'], $basicForm['unit_type'], $basicForm['price_paid'], $basicForm['id']));
        if($result) {
            return array('area' => 'main', 'type'=>'success', 'message'=>'Save completed', 'insert_id' => $basicForm['id']);
        } else {
            return array('area' => 'main', 'type'=>'failure', 'message'=>'Database error');     
        }
    }

    /**
    *  Inserts an Resource
    */
    public function addResource($basicForm) {
        $sql = "INSERT INTO resource (name, description, date_bought, size, unit_type, price_paid) VALUES(?,?,?,?,?,?)";
        $result = $this->db->query($sql, array($basicForm['name'], $basicForm['description'], $basicForm['date_bought'], $basicForm['size'], $basicForm['unit_type'], $basicForm['price_paid']));
        if($result) {
            return array('area' => 'main', 'type'=>'success', 'message'=>'Save completed', 'insert_id' => $this->db->insert_id());
        } else {
            return array('area' => 'main', 'type'=>'failure', 'message'=>'Database error');     
        }
    }

    /**
    *   Deletes a Resource
    */
    public function deleteResource($id) {
        $sql = "DELETE FROM resource WHERE id = ?";
        $result = $this->db->query($sql, array($id));
        if($result) {
            return array('area' => 'main', 'type'=>'success', 'message'=>'Delete completed');
        } else {
            return array('area' => 'main', 'type'=>'failure', 'message'=>'Database error');     
        }
    }
}