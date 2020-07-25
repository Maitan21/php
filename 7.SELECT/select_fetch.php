<?php
    $conn = mysqli_connect("localhost", 
    "root", 
    "sang0626",
    "opentutorials");

    
    $sql = "SELECT * FROM topic";
    $result = mysqli_query($conn, $sql);

    //첫번째 행을 가져옴
    $row = mysqli_fetch_array($result);
    echo '<h1>'.$row['title'].'</h1>';
    echo $row['description'];
     
?>