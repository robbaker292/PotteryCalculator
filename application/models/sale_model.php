<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sale_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /*
    * Returns all the data about the given Resource
    */
    public function getSale($id) {
        $sql = "SELECT * FROM sale WHERE id=?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    /*
    * Returns all the data about payment methods
    */
    public function getPaymentMethods() {
        $sql = "SELECT * FROM payment_method";
        $query = $this->db->query($sql);
        return $query->result();
    }

    /*
    * Returns all the data about products
    */
    public function getProducts() {
        $sql = "SELECT * FROM product";
        $query = $this->db->query($sql);
        return $query->result();
    }

    /*
    * Returns all the data about events
    */
    public function getEvents() {
        $sql = "SELECT * FROM event";
        $query = $this->db->query($sql);
        return $query->result();
    }

    /**
    *   Gets the details of a potential sale
    *   NOTE: the +1 for calculated cost - need to take into account this potential sale
    */
    public function getPotentialSale($product, $event, $pm, $date) {
        $sql = "SELECT IFNULL(pm.cut,0) AS 'cut',
            IFNULL((SELECT IFNULL(ev.cost_upfront,0)/(COUNT(s2.id)+1) FROM event ev JOIN sale s2 ON s2.event = ev.id WHERE ev.id=? GROUP BY ev.id),0) AS calculated_cost_upfront,
            IFNULL(e.cost_sales,0) AS cost_sales,
            (SELECT SUM( (pr.amount / r.size) * r.price_paid) FROM product p2 JOIN product_resource pr ON p2.id = pr.pid JOIN resource r ON r.id = pr.rid WHERE p2.id = ? GROUP BY p.id) AS parts_cost,
            (SELECT rate/100 FROM vat WHERE ? BETWEEN vat.start AND IFNULL(vat.end,DATE_ADD(CURDATE(), INTERVAL 10 YEAR))) AS vat,
            p.time, e.id AS 'event_id', e.name AS 'event_name', e.location AS 'event_location'
            FROM product p
            LEFT JOIN event e ON ? = e.id
            LEFT JOIN payment_method pm ON ? = pm.type
            WHERE p.id=?";
        $query = $this->db->query($sql, array($event, $product, $date, $event, $pm, $product));
        return $query->result();

    }

    /**
    *  Updates a product
    */
    public function editSale($basicForm) {
        $sql = "UPDATE sale SET date=?, sale_price=?, payment_method=?, product=?, event=? WHERE id=?";
        $result = $this->db->query($sql, array($basicForm['date'], $basicForm['sale_price'], $basicForm['payment_method'], $basicForm['product'], $basicForm['event'], $basicForm['id']));
        if($result) {
            return array('area' => 'main', 'type'=>'success', 'message'=>'Save completed', 'insert_id' => $this->db->insert_id());
        } else {
            return array('area' => 'main', 'type'=>'failure', 'message'=>'Database error');     
        }
    }

    /**
    *  Inserts a product
    */
    public function addSale($basicForm) {
        $sql = "INSERT INTO sale (date, sale_price, payment_method, product, event) VALUES(?,?,?,?,?)";
        $result = $this->db->query($sql, array($basicForm['date'], $basicForm['sale_price'], $basicForm['payment_method'], $basicForm['product'], $basicForm['event']));
        if($result) {
            return array('area' => 'main', 'type'=>'success', 'message'=>'Save completed', 'insert_id' => $this->db->insert_id());
        } else {
            return array('area' => 'main', 'type'=>'failure', 'message'=>'Database error');     
        }
    }

    /**
    *   Deletes a product
    */
    public function deleteSale($id) {
        $sql = "DELETE FROM sale WHERE id = ?";
        $result = $this->db->query($sql, array($id));
        if($result) {
            return array('area' => 'main', 'type'=>'success', 'message'=>'Delete completed');
        } else {
            return array('area' => 'main', 'type'=>'failure', 'message'=>'Database error');     
        }
    }
}