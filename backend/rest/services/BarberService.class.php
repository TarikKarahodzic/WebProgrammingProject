<?php

require_once __DIR__ . '/../dao/BarberDao.class.php';

class BarberService
{
    private $barber_dao;

    public function __construct()
    {
        $this->barber_dao = new BarberDao();
    }

    public function add_barber($barber)
    {
        return $this->barber_dao->add_barber($barber);
    }

    public function get_barbers_paginated($offset, $limit, $search, $order_column, $order_direction)
    {
        $count = $this->barber_dao->count_barbers_paginated($search)['count'];
        $rows = $this->barber_dao->get_barbers($offset, $limit, $search, $order_column, $order_direction);

        return [
            'count' => $count,
            'data' => $rows,
        ];
    }

    public function delete_barber_by_id($barber_id)
    {
        $this->barber_dao->delete_barber_by_id($barber_id);
    }

    public function get_barber_by_id($id)
    {
        return $this->barber_dao->get_barber_by_id($id);
    }

    public function edit_barber($barber)
    {
        $id = $barber['barber_id'];
        unset($barber['barber_id']);

        $this->barber_dao->edit_barber($id, $barber);
    }
}
