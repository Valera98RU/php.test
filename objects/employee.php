<?php

    class Employee{

        private $table_name = "employee";
        private $conn;

        private $name;
        private $position;
        private $date_employee;
        private $state;

        public function __construct($db){
            $this->conn = $db;
        }

        public function getName(){
            return $this->name;
        }

        public function getPosition(){
            return $this->position;
        }
        public function getDateEmployee(){
            return $this->date_employee;
        }
        public function getState(){
            return $tjis->state;
        }
        public function getListCount(){
            $sql = "SELECT COUNT(*) FROM `employee`"; 
            $result = $this->conn->query($sql);           
            $number_of_rows = $result->fetchColumn(); 

            return $number_of_rows;
        }

        public function getList(?string  $name,  $numPage){

            $max_limit = ($numPage*10);
            $min_limit = 0+10*($numPage-1);
            
           
            $sql_query = "SELECT employee.id,employee.name, employee.date_employment,employee.state, position.name_position FROM ".$this->table_name." LEFT OUTER JOIN position ON employee.id_position = position.id LIMIT ".$min_limit.",".$max_limit;
            
            if(!empty($name)){
                $sql_query  = $sql_query." WHERE employee.name LIKE '%".$name."%'";
            }

            $stmt = $this->conn->query($sql_query);
           
            $result = array();

            foreach($stmt as $row){
                array_push($result, array(
                    "id"=>$row["id"],
                    "name"=>$row["name"],
                    "name_position"=>$row["name_position"],
                    "date_employment"=>$row["date_employment"],
                    "state"=>$row["state"]
                ));
            }
            return $result;
        }
        public function getOneEmployee($id){
            $sql_query = "SELECT employee.id,employee.name, employee.date_employment,employee.state, employee.id_position FROM ".$this->table_name." WHERE id = ".$id;            
            

            $stmt = $this->conn->query($sql_query);
           
            $result = array();

            foreach($stmt as $row){
                $result = array(
                    "id"=>$row["id"],
                    "name"=>$row["name"],
                    "id_position"=>$row["id_position"],
                    "date_employment"=>$row["date_employment"],
                    "state"=>$row["state"]
                );
            }
            return $result;
        }


        public function update($id,$name, $date, $id_position,$state){
           

            $sql_string = "UPDATE employee SET employee.name=?, employee.date_employment=?, employee.state=?, employee.id_position=? WHERE employee.id=?";
            $stmt= $this->conn->prepare($sql_string);
            $stmt->execute([$name, $date, $state, $id_position, $id]);

            return $stmt;
        }

        public function delete($id){
            $sql_string = "DELETE FROM employee WHERE id=".$id;
            $this->conn->query($sql_string);
        }

        
    }