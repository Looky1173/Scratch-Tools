<?php

// This class is used to connect to the database
class Db
{
    // Define database credentials
    private $host = 'localhost';
    private $db   = 'scratch_tools';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8mb4';

    // Define connection options
    private $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    public function connect()
    // Initialise a connection to the database
    {
        try {
            // Define data source name (dsn)
            $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
            $pdo = new PDO($dsn, $this->user, $this->pass, $this->options);
            // Return the connection
            return $pdo;
        } catch (PDOException $e) {
            // Throw error if connection was unsuccessful
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }




    /*
    private $host = "localhost";
    private $user = "root";
    private $pwd = "";
    private $dbName = "scratch_tools";

    protected function connect() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
        $pdo = new PDO($dsn, $this->user, $this->pwd);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }*/
}
