<?php

require_once __DIR__ . "/BaseDao.class.php";

class BarberDao extends BaseDao {
    public function __construct() {
        parent::__construct('barbers');
    }

    public function add_barber($barber) {
        // TODO implement add logic
        
        return $barber;
    }
}