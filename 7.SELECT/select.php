<?php
    include_once '../6.CREATE_SQL/create.php';

    global $db;
    $sql = "SELECT * FROM topic LIMIT 1000";
    $result = mysqli_query($conn,$sql);
    var_dump($result);
