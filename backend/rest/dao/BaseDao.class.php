<?php

require_once __DIR__ . "/../../config.php";

class BaseDao
{
    protected $connection;
    private $table;

    public function __construct($table)
    {
        $this->table = $table;
        try {
            $this->connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,
                DB_USER,
                DB_PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC //all of the rows in our table should be returned as associative arrays
                ]
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }

    protected function query($query, $params = [])
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    function get_all()
    {
        $stmt = $this->query("SELECT * FROM " . $this->table);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getById($id)
    {
        $stmt = $this->query("SELECT * FROM " . $this->table . " WHERE id = :id", ["id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($entity)
    {
        $query = "INSERT INTO " . $this->table . " (";
        foreach ($entity as $column => $value) {
            $query .= $column . ", ";
        }
        $query = substr($query, 0, -2);
        $query .= ") VALUES (";
        foreach ($entity as $column => $value) {
            $query .= ":" . $column . ", ";
        }
        $query = substr($query, 0, -2);
        $query .= ")";

        $stmt = $this->connection->prepare($query);
        $stmt->execute($entity);
        $entity['id'] = $this->connection->lastInsertId();
        return $entity;
    }

    public function delete($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM " . $this->table . " WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function update($id, $entity, $id_column = "id")
    {
        $query = "UPDATE " . $this->table . " SET ";
        foreach ($entity as $column => $value) {
            $query .= $column . "= :" . $column . ", ";
        }
        $query = substr($query, 0, -2);
        $query .= " WHERE $id_column = :id";

        $stmt = $this->connection->prepare($query);
        $entity['id'] = $id;
        $stmt->execute($entity);
    }

    public function get_user_by_email($email) {
        $stmt = $this->query("SELECT * FROM users WHERE user_email = :user_email",["user_email" => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add_date($entity)
{
    // Construct the SQL query
    $columns = implode(", ", array_keys($entity));
    $values = ":" . implode(", :", array_keys($entity));

    $query = "INSERT INTO " . $this->table . " ($columns) VALUES ($values)";

    // Prepare and execute the SQL query
    $stmt = $this->connection->prepare($query);
    $stmt->execute($entity);

    // Return the inserted entity with its ID
    $entity['id'] = $this->connection->lastInsertId();
    return $entity;
}

}