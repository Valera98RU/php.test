<?php
$name = $_POST['fname'];
$rno = $_POST['id'];
$host = "localhost";
$db_name = "school";
$db_user_name = "root";
$db_user_password = "root";
$db_type = "mysql";
$unexpected_message = "Stydent is unexpected";

$db = new PDO($db_type.":host=".$host.";dbname=".$db_name,$db_user_name,$db_user_password);
$query_string = "SELECT address from students where name='".$name."' AND rno=".$rno;
$stmt = $db->query($query_string);

$request = "";
if($stmt->execute()){
    while($row=$stmt->fetch()){
       
        $request = $row['address'];
    }
}
if( $request != ""){
    echo $request;
}else{
    echo $unexpected_message;
}

?>