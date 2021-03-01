<?php

    class Position{

        private $table_name = "position";
        private $conn;
        
        public function __construct($db){
            $this->conn = $db;
        }
        public function getPOsitionList(){
            $sql_query = "SELECT * FROM ".$this->table_name;            
            

            $stmt = $this->conn->query($sql_query);
           
            $result = array();
            while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                array_push($result, array(
                    "id"=>$row["id"],
                    "name"=>$row["name_position"]
                    
                ));
            }
           
                
           
            return $result;
        }
    }