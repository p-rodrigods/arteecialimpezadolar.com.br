<?php 

namespace app;

class Connection
{
    public static function getDb()
    {
      /*try {
            $conn = new \PDO("mysql:host=arteecialimpezadolar.com.br;dbname=u504967134_db_arteecia", "u504967134_db_arteecia", ">VoGF6;Vl1");
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }*/
        try {
            $conn = new \PDO("mysql:host=localhost;dbname=db_arteecia", "root", "");
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

    }
}