<?php

    class Database{
        // DB params
        private $host = 'localhost';
        private $dbName = 'apischedulist';
        private $username = 'root';
        private $password = '';
        private $conn;

        // DB connect
        public function connect(){
            $this->conn = null;
            $dsn = 'mysql:host='. $this->host . ';dbname='. $this->dbName;

            try {
                $this->conn = new PDO($dsn, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'Connection Error' .$e->getMessage();
            }
            return $this->conn;
        }
    }
