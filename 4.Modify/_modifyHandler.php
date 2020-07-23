<?php
    include_once '_query_inc.php';

    $_name = $_POST['name'];
    $_birth = $_POST['birth'];
    $_phone = $_POST['phone'];
    $_purpose = $_POST['purpose'];

?>

<?php
     try{
         $db->begin_tran();
         modifyVisitState($_REQUEST["list_id"][1],$_name,$_birth,$_phone,$_purpose);

         $db->commit();
?>
         <scrript type="text/javascript">
         alert("방문자 정보수정을 완료 하였습니다.");
         location.href="list.php";
         </script>
<?
     } catch(Exception $e) {
         $db ->rollback();
         $result_message = "방문자 정보 수정을 실패하였습니다." . $e->getMessage();
     }
?>