<?php

require_once __DIR__ . '/BaseService.class.php';
require_once __DIR__ . '/../dao/BarberDao.class.php';

class BarberService extends BaseServices
{
    public function __construct()
    {
        parent::__construct(new BarberDao);
    }
}
