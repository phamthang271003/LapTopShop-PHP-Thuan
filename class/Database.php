<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $host = "localhost";
        $db = "webbanhang";
        $user = "websitebanhang_admin";
        $pass = "Qy@KAGJ3P0/A6LBx";

        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

        try {
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            throw new Exception("Database connection failed: " . $ex->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
?>
