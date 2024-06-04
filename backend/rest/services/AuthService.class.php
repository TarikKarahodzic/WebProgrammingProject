<?php

require_once __DIR__ . '/BaseService.class.php';
require_once __DIR__ . '/../dao/AuthDao.class.php';

class AuthService extends BaseServices
{
    public function __construct()
    {
        parent::__construct(new AuthDao);
    }
}
