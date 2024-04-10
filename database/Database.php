<?php

namespace database;

use PDO;

class Database
{

    private $host = 'localhost';
    private $dbname = 'web_viver';
    private $username = 'root';
    private $password = '6jfmd672@V';
    private $charset = 'utf8mb4';

    private $pdo;
    private $stmt;

    public function __construct() {
        // Set DSN (Data Source Name)
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

        // Set options
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        // Create a new PDO instance
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    // Prepare a query
    public function query($sql) {
        $this->stmt = $this->pdo->prepare($sql);
    }

    // Bind parameters
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute() {
        return $this->stmt->execute();
    }

    // Get result set as an array of associative arrays
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    // Get a single record as an associative array
    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

    // Get the row count
    public function rowCount() {
        return $this->stmt->rowCount();
    }
    // Insert a new item and get the auto-incremented ID
    public function insertAndGetId($sql, $params = []) {
        $this->query($sql);
        foreach ($params as $param => $value) {
            $this->bind($param, $value);
        }
        $this->execute();
        return $this->pdo->lastInsertId();
    }
}
