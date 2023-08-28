<?php

namespace App\Model;

class Model
{
    protected $db;
    protected $config;
    protected $table;
    function __construct()
    {
        include project_path().'/config/app.php';
        $this->config = $config;

        $this->db = new \PDO(
            "mysql:host={$this->config['db_host']};dbname={$this->config['db_name']}",
            $this->config['db_user'],
            $this->config['db_password']
        );
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    public function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $query = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";

        $statement = $this->db->prepare($query);
        $statement->execute(array_values($data));
        return $this->db->lastInsertId(); // Return the inserted ID
    }

    public function read($conditions = [])
    {
        $query = "SELECT * FROM $this->table";
        $queryParams = [];

        if (!empty($conditions)) {
            $query .= " WHERE ";
            $conditionsArray = [];
            foreach ($conditions as $column => $value) {
                $conditionsArray[] = "$column = ?";
                $queryParams[] = $value;
            }
            $query .= implode(" AND ", $conditionsArray);
        }

        $statement = $this->db->prepare($query);
        $statement->execute($queryParams);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function update($data, $conditions)
    {
        $updateFields = [];
        foreach ($data as $column => $value) {
            $updateFields[] = "$column = ?";
        }

        $query = "UPDATE $this->table SET " . implode(', ', $updateFields);

        if (!empty($conditions)) {
            $query .= " WHERE ";
            $conditionsArray = [];
            foreach ($conditions as $column => $value) {
                $conditionsArray[] = "$column = ?";
                $queryParams[] = $value;
            }
            $query .= implode(" AND ", $conditionsArray);
        }

        $statement = $this->db->prepare($query);
        $statement->execute(array_merge(array_values($data), $queryParams));
        return $statement->rowCount();
    }

    public function delete($conditions)
    {
        $query = "DELETE FROM $this->table";

        if (!empty($conditions)) {
            $query .= " WHERE ";
            $conditionsArray = [];
            foreach ($conditions as $column => $value) {
                $conditionsArray[] = "$column = ?";
                $queryParams[] = $value;
            }
            $query .= implode(" AND ", $conditionsArray);
        }

        $statement = $this->db->prepare($query);
        $statement->execute($queryParams);
        return $statement->rowCount();
    }
}
