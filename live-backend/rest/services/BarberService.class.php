<?php

require_once __DIR__ . '/../dao/BarberDao.class.php';

class BarberService {
    private $barber_dao;

    public function __construct() {
        $this->barber_dao = new BarberDao();
    }
    public function add_barber($barber) {
        return $this->barber_dao->add_barber($barber);
    }
}
