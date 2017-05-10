<?php
session_start();
$is_logged = $_SESSION['is_logged'];
if($is_logged=='YES') {
    $user_id = $_SESSION['user_id'];
    $message = $user_id . ' 님, 로그인 했습니다.';
}
else {
    $message = '로그인이 실패했습니다.';
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>로그인 완료 페이지</title>
        <meta charset="utf-8" >
    </head>



    <body>
       
      
<div class = "header">
<?php include $_SERVER['DOCUMENT_ROOT'].'/header.php';?>
</div>		
 
<div class="content">
            <br>
<?php echo $message; ?><br/>


    </div>

<div class = "footer">
<?php include $_SERVER['DOCUMENT_ROOT'].'/footer.php';?> 
</div>




    </body>


</html> 
