<?php
    class DataBase{
        private $host = "localhost";
        private $db_name = "php_test";
        private $user_name = "root";
        private $user_password = "root";
        public $conn;

       private  $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
       ];

        public function getConnection(){
            $this->conn= null;

            try{
                $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->user_name, $this->user_password, $this->opt);
                $this->conn->exec("set names utf8");
            }catch(PDOExceptoion $ex){
                echo "Connection error" .$ex->getMessage();
            }

            return $this->conn;
        }
    }