<?php
    include_once("objects/employee.php");
    include_once("config/database.php");
    session_start ();
    $db = new DataBase;
    $db = $db->getConnection();
    $employeLab = new Employee($db);  

    $id=$_SESSION["id"];
    $name = $_POST["fname"];
    $date = $_POST["date"];
    $state = $_POST["state"];
    $id_position = $_POST["id_position"];    

    $employeLab->update($id,$name,$date,$id_position,$state);

    echo $name." ".$date." ".$state." ".$id_position." ".$id ;