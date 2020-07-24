<?php
// 삽입  첫 괄호 칼럼명 VALUES -> row 값
$conn = mysqli_connect("localhost", "root", "sang0626", "opentutorials");

$sql  = "
    INSERT INTO topic (  
        title,
        description,
        created
    ) VALUES (
        'MySQL',
        'MySQL is ....',
        NOW()
    )";
$result = mysqli_query($conn, $sql); //true , bool 값 리턴
if($result === false){
     //커넥션 오류값 표시
    echo mysqli_error($conn);
}

?> 
