<?php
$conn = mysqli_connect("localhost", 
"root", 
"sang0626",
"opentutorials");

$sql = "
    INSERT INTO topic
        (title, description, created)
    VALUES(
        '{$_POST['title']}', 
        '{$_POST['description']}',
        NOW()
    )
";
$reuslt = mysqli_query($conn,$sql);
if($result === flase){
    echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의하여주세요';
    error_log(mysqli_error($conn));
} else {
    echo '저장에 성공하였습니다.';
}
?>