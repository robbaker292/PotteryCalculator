<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Event_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /*
    * Returns all the data about the given casualty
    */
    public function getEvent($id) {
        $sql = "SELECT * FROM event WHERE id=?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

/**
    * Gets the sales of the given event
    */
    public function getSales($id) {
        $sql = "SELECT s.id AS 'sale_id', s.date, s.sale_price, s.payment_method, IFNULL(pm.cut,0) AS 'cut',
            IFNULL((SELECT IFNULL(ev.cost_upfront,0)/(COUNT(s2.id)) FROM event ev JOIN sale s2 ON s2.event = ev.id WHERE ev.id=s.event GROUP BY ev.id),0) AS calculated_cost_upfront,
            IFNULL(e.cost_sales,0) AS cost_sales,
            IFNULL(s.sale_price,0) AS sale_price,
            (SELECT SUM( (pr.amount / r.size) * r.price_paid) FROM product p JOIN product_resource pr ON p.id = pr.pid JOIN resource r ON r.id = pr.rid WHERE p.id = s.product GROUP BY p.id) AS parts_cost,
            (SELECT rate/100 FROM vat WHERE s.date BETWEEN vat.start AND IFNULL(vat.end,DATE_ADD(CURDATE(), INTERVAL 10 YEAR))) AS vat,
            p.time, e.id AS 'event_id', e.name AS 'event_name', e.location AS 'event_location', p.name AS 'product_name', p.id AS 'product_id'
            FROM sale s
            LEFT JOIN event e ON s.event = e.id
            LEFT JOIN payment_method pm ON s.payment_method = pm.type
            JOIN product p ON p.id = s.product
            WHERE s.event=?
        ";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

}