<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /*
    * Returns all the data about the given product
    */
    public function getProduct($id) {
        $sql = "SELECT * FROM product WHERE id=?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    /*
    * Returns all the data about all products
    */
    public function getAllProducts() {
        $sql = "SELECT * FROM product";
        $query = $this->db->query($sql);
        return $query->result();
    }


    /*
    *   Gets the full information and profit calculations for the given product
    */
    public function getFullProduct($id) {
        $sql = "
            SELECT p.id, p.name, p.description, p.time, p.sold, p.event, e.name AS 'event_name', e.location,
                IFNULL((SELECT IFNULL(ev.cost_upfront,0)/(COUNT(p.id)) FROM event ev JOIN product p ON p.event = ev.id WHERE ev.id=e.id GROUP BY ev.id),0) AS calculated_cost_upfront,
                FORMAT(IFNULL(e.cost_sales,0),2) AS cost_sales,
                IFNULL(p.sale_price,0) AS sale_price,
                FORMAT(IFNULL(p.sale_price,0)/(1+IFNULL((SELECT rate/100 FROM vat WHERE p.sold BETWEEN vat.start AND IFNULL(vat.end,DATE_ADD(CURDATE(), INTERVAL 10 YEAR))),0)),2) AS revenue,
                FORMAT(SUM( (pr.amount / r.size) * r.price_paid),2) AS parts_cost,
                FORMAT(
                    (((IFNULL(p.sale_price,0)/(1+IFNULL((SELECT rate/100 FROM vat WHERE p.sold BETWEEN vat.start AND IFNULL(vat.end,DATE_ADD(CURDATE(), INTERVAL 10 YEAR))),0)
                    
                    ))/(1-IFNULL(e.cost_sales,0)))-IFNULL((SELECT IFNULL(ev.cost_upfront,0)/(COUNT(p.id)) FROM event ev JOIN product p ON p.event = ev.id WHERE ev.id=e.id GROUP BY ev.id),0)) - SUM( (pr.amount / r.size) * r.price_paid)
                 ,2) AS profit,
                FORMAT(
                ((((IFNULL(p.sale_price,0)/(1+IFNULL((SELECT rate/100 FROM vat WHERE p.sold BETWEEN vat.start AND IFNULL(vat.end,DATE_ADD(CURDATE(), INTERVAL 10 YEAR))),0)
                ))/(1-IFNULL(e.cost_sales,0)))-IFNULL((SELECT IFNULL(ev.cost_upfront,0)/(COUNT(p.id)) FROM event ev JOIN product p ON p.event = ev.id WHERE ev.id=e.id GROUP BY ev.id),0)) - SUM( (pr.amount / r.size) * r.price_paid))
                /p.time,2) AS hourly_rate,
                p.unsellable
                FROM product p
                JOIN product_resource pr ON pr.pid = p.id
                JOIN resource r ON pr.rid = r.id
                LEFT JOIN event e ON e.id = p.event
                WHERE p.id = ?
                GROUP BY p.id      
            ";
         $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    /**
    * Gets the sales of the given product
    */
    public function getSales($id) {
        $sql = "SELECT s.id AS 'sale_id', s.date, s.sale_price, s.payment_method, IFNULL(pm.cut,0) AS 'cut',
            IFNULL((SELECT IFNULL(ev.cost_upfront,0)/(COUNT(s2.id)) FROM event ev JOIN sale s2 ON s2.event = ev.id WHERE ev.id=s.event GROUP BY ev.id),0) AS calculated_cost_upfront,
            IFNULL(e.cost_sales,0) AS cost_sales,
            IFNULL(s.sale_price,0) AS sale_price,
            (SELECT SUM( (pr.amount / r.size) * r.price_paid) FROM product p JOIN product_resource pr ON p.id = pr.pid JOIN resource r ON r.id = pr.rid WHERE p.id = s.product GROUP BY p.id) AS parts_cost,
            (SELECT rate/100 FROM vat WHERE s.date BETWEEN vat.start AND IFNULL(vat.end,DATE_ADD(CURDATE(), INTERVAL 10 YEAR))) AS vat,
            p.time, e.id AS 'event_id', e.name AS 'event_name', e.location AS 'event_location'
            FROM sale s
            LEFT JOIN event e ON s.event = e.id
            LEFT JOIN payment_method pm ON s.payment_method = pm.type
            JOIN product p ON p.id = s.product
            WHERE product=?
        ";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    /**
    * Gets the resources of the given product
    */
    public function getResources($id) {
        $sql = "SELECT * FROM resource r JOIN product_resource pr ON pr.rid = r.id WHERE pr.pid = ?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

}