<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function getAllVat() {
        $sql = "SELECT * FROM vat";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getAllPM() {
        $sql = "SELECT * FROM payment_method";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getVat($id) {
        $sql = "SELECT * FROM vat WHERE id=?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    public function getPM($id) {
        $sql = "SELECT * FROM payment_method WHERE type=?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    /**
    *  Updates a VAT rate
    */
    public function editVAT($basicForm) {
        $sql = "UPDATE vat SET start=?, end=?, rate=? WHERE id=?";
        $result = $this->db->query($sql, array($basicForm['start'], $basicForm['end'], $basicForm['rate'], $basicForm['id']));
        if($result) {
            return array('area' => 'main', 'type'=>'success', 'message'=>'Save completed', 'insert_id' => $basicForm['id']);
        } else {
            return array('area' => 'main', 'type'=>'failure', 'message'=>'Database error');     
        }
    }

    /**
    *  Inserts a vat rate
    */
    public function addVAT($basicForm) {
        $sql = "INSERT INTO vat (start, end, rate) VALUES(?,?,?)";
        $result = $this->db->query($sql, array($basicForm['start'], $basicForm['end'], $basicForm['rate']));

        if($result) {
            return array('area' => 'main', 'type'=>'success', 'message'=>'Save completed', 'insert_id' => $this->db->insert_id());
        } else {
            return array('area' => 'main', 'type'=>'failure', 'message'=>'Database error');     
        }
    }

    /**
    *  Updates a PM rate
    */
    public function editPM($basicForm) {
        $sql = "UPDATE payment_method SET type=?, cut=? WHERE type=?";
        $result = $this->db->query($sql, array($basicForm['type'], $basicForm['cut'], $basicForm['id']));
        if($result) {
            return array('area' => 'main', 'type'=>'success', 'message'=>'Save completed', 'insert_id' => $basicForm['type']);
        } else {
            return array('area' => 'main', 'type'=>'failure', 'message'=>'Database error');     
        }
    }

    /**
    *  Inserts a PM
    */
    public function addPM($basicForm) {
        $sql = "INSERT INTO payment_method (type, cut) VALUES(?,?)";
        $result = $this->db->query($sql, array($basicForm['type'], $basicForm['cut']));

        if($result) {
            return array('area' => 'main', 'type'=>'success', 'message'=>'Save completed', 'insert_id' => $this->db->insert_id());
        } else {
            return array('area' => 'main', 'type'=>'failure', 'message'=>'Database error');     
        }
    }

}