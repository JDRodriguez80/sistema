<?php
class Database
{
    private $host = "localhost:3306";
    private $db_name = "siiecamv1.0";
    private $username = "root";
    private $password = "";
    private $charset = "utf8";

    public function conectar()
    {
        try {
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($connection, $this->username, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            print_r('Error conexion: ' . $e->getMessage());
        }
    }
}


