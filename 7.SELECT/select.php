<?php
//    include_once '../6.CREATE_SQL/create.php';


    $conn = mysqli_connect("localhost", 
    "root", 
    "sang0626",
    "opentutorials");
    $sql = "SELECT * FROM topic LIMIT 1000";
    $result = mysqli_query($conn,$sql);
    var_dump($result);
  

?>