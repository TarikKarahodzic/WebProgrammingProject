<?php

require_once __DIR__ . '/BaseService.class.php';
require_once __DIR__ . '/../dao/ServiceDao.class.php';

class ServiceService extends BaseServices
{
    public function __construct()
    {
        parent::__construct(new ServiceDao);
    }
}
