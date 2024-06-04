<?php

require_once __DIR__ . "/BaseDao.class.php";

class BarberDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('barbers');
    }
}
