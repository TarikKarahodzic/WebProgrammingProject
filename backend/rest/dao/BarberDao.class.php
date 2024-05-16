<?php

require_once __DIR__ . "/BaseDao.class.php";

class BarberDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('barbers');
    }

    public function add_barber($barber)
    {
        $query = "INSERT INTO barbers (barber_name, barber_phoneNumber, barber_email, barber_password, work_start_time, work_end_time, days_off)
                    VALUES(:barber_name, :barber_phoneNumber, :barber_email, :barber_password, :work_start_time, :work_end_time, :days_off)";
        $statement = $this->connection->prepare($query);
        $params = [
            ':barber_name' => $barber['full_name'],
            ':barber_phoneNumber' => $barber['phone_number'],
            ':barber_email' => $barber['email'],
            ':barber_password' => $barber['password'],
            ':work_start_time' => $barber['start_time'],
            ':work_end_time' => $barber['end_time'],
            ':days_off' => $barber['days_off']
        ];
        $statement->execute($params);
        $barber['barber_id'] = $this->connection->lastInsertId();
        return $barber;
    }

    public function count_barbers_paginated($search)
    {
        $query = "SELECT COUNT(*) AS count 
                    FROM barbers
                    WHERE LOWER(barber_name) LIKE CONCAT('%', :search, '%')";
        return $this->query_unique($query, [
            'search' => $search
        ]);
    }

    public function get_barbers($offset, $limit, $search)
    {
        $query = "SELECT * 
                  FROM barbers
                  WHERE LOWER(barber_name) LIKE CONCAT('%', :search, '%')
                  LIMIT {$offset}, {$limit}";
        return $this->query($query, ['search' => strtolower($search)]);
    }

    public function delete_barber_by_id($barber_id)
    {
        $query = "DELETE FROM barbers WHERE barber_id = :barber_id";
        $this->execute($query, [
            'barber_id' => $barber_id
        ]);
    }

    public function get_barber_by_id($barber_id)
    {
        return $this->query_unique(
            "SELECT * FROM barbers WHERE barber_id = :barber_id",
            [
                'barber_id' => $barber_id
            ]
        );
    }

    public function edit_barber($id, $barber)
    {
        $query = "UPDATE barbers SET 
                  barber_name = :barber_name,
                  barber_phoneNumber = :barber_phoneNumber,
                  barber_email = :barber_email,
                  barber_password = :barber_password,
                  work_start_time = :work_start_time,
                  work_end_time = :work_end_time,
                  days_off = :days_off
                  WHERE barber_id = :barber_id";
        $this->execute($query, [
            'barber_name' => $barber['full_name'],
            'barber_phoneNumber' => $barber['phone_number'],
            'barber_email' => $barber['email'],
            'barber_password' => $barber['password'],
            'work_start_time' => $barber['start_time'],
            'work_end_time' => $barber['end_time'],
            'days_off' => $barber['days_off'],
            'barber_id' => $id
        ]);
    }
}
