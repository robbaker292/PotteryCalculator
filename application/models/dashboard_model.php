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
    public function getSales($start_date, $end_date, $group = null) {
        $sql_start = "SELECT s.id AS 'sale_id', s.date, s.sale_price, s.payment_method, IFNULL(pm.cut,0) AS 'cut',
            IFNULL((SELECT IFNULL(ev.cost_upfront,0)/(COUNT(s2.id)) FROM event ev JOIN sale s2 ON s2.event = ev.id WHERE ev.id=s.event GROUP BY ev.id),0) AS calculated_cost_upfront,
            IFNULL(e.cost_sales,0) AS cost_sales,
            IFNULL(s.sale_price,0) AS sale_price,
            (SELECT SUM( (pr.amount / r.size) * r.price_paid) FROM product p JOIN product_resource pr ON p.id = pr.pid JOIN resource r ON r.id = pr.rid WHERE p.id = s.product GROUP BY p.id) AS parts_cost,
            (SELECT rate/100 FROM vat WHERE s.date BETWEEN vat.start AND IFNULL(vat.end,DATE_ADD(CURDATE(), INTERVAL 10 YEAR))) AS vat,
            p.time, e.id AS 'event_id', e.name AS 'event_name', e.location AS 'event_location', p.id AS 'product_id', p.name AS 'product_name'
            FROM sale s
            LEFT JOIN event e ON s.event = e.id
            LEFT JOIN payment_method pm ON s.payment_method = pm.type
            JOIN product p ON p.id = s.product 
        ";
            
        $sql_end = " ORDER BY s.date ASC";

        if($group == "day" || $group == null) { //if the search is for a particular date or date range
            $sql = $sql_start."WHERE (s.date BETWEEN ? AND ?)".$sql_end;
            $query = $this->db->query($sql, array($start_date->format('Y-m-d'), $end_date->format('Y-m-d')));
            return $query->result();
        } elseif($group == "week") { //if the search is for a particular week
            $sql = $sql_start."WHERE WEEK(s.date) = ?".$sql_end;
            $query = $this->db->query($sql, array($start_date));
            return $query->result();
        } elseif($group == "month") { //if the search is for a particular month
            $sql = $sql_start."WHERE MONTH(s.date) = ?".$sql_end;
            $query = $this->db->query($sql, array($start_date));
            return $query->result();
        }

    }

}