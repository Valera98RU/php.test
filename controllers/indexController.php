<?php
    include_once("../objects/employee.php");
    include_once("../config/database.php");
    session_start ();
    $db = new DataBase;
    $db = $db->getConnection();
    $employeLab = new Employee($db); 
    


    if($_POST["method"]=="getListInfo"){

        $search_string = $_POST["search"];
        $numPage = $_POST["num_page"];
       

       
        
        if($search_string == ""){
            $search_string=null;           
        }
       
        
         $employeersArray = $employeLab->getList($search_string, $numPage);

         $json_string = array(
             "body"=>array());
        foreach($employeersArray as $row){
            array_push( $json_string["body"],
            array(
                "id"=>$row["id"],
                "name"=>$row["name"],
                "date"=>$row["date_employment"],
                "position"=>$row["name_position"],
                "state"=>$row["state"]
            )  
        );
        }
        echo  json_encode($json_string);
        
    }
    if($_POST["method"]=="getListCount"){
        
        echo $employeLab->getListCount();
    }
    if($_POST["method"]=="deletPerson"){
        $id = $_POST["id"];
        $employeLab->delete( $id);
    }
    