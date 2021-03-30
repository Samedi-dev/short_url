<?php

namespace App\Services;

use PDO;
use PDOException;

class ConnectionDB
{
    private string $db_driver;
    private string $db_host;
    private string $db_dbname;
    private string $db_user;
    private string $db_password;
    private string $dsn;
    private PDO $connection;

    protected function __construct()
    {
        $config = include('config/database.php');

        $this->db_driver = $config['db_driver'];
        $this->db_host = $config['db_host'];
        $this->db_dbname = $config['db_dbname'];
        $this->db_user = $config['db_user'];
        $this->db_password = $config['db_password'];
        $this->dsn = $this->db_driver . ':host=' . $this->db_host . ';dbname=' . $this->db_dbname;
    }

    protected function connect()
    {
        try {
            $this->connection = new PDO(
                $this->dsn,
                $this->db_user,
                $this->db_password
            );
        } catch(PDOException $e) {
            Logger::setLog($e->getMessage());
        }
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $this->connection;
    }
}